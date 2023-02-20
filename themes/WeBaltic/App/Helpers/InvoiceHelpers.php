<?php

use App\Facades\Media;
use App\Models\Upload;
use App\Models\Invoice;
use App\Facades\Payments;
use App\Facades\Countries;
use App\Facades\TaxService;
use App\Enums\OrderTypeEnum;
use App\Enums\UserEntityEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice as LaravelInvoice;

if (!function_exists('generateInvoice')) {
    function generateInvoice(&$form) {
        if($form->order->invoices->isEmpty()) {
            if($form->order->type === OrderTypeEnum::installments()->value) {
                // For installments create multiple invoices (deposit and main invoice)
                $deposit_amount = $form->order->getWEF('deposit_amount');

                $deposit_totals = [
                    'base_price' => $form->order->base_price * $deposit_amount / 100,
                    'discount_amount' => $form->order->discount_amount * $deposit_amount / 100,
                    'subtotal_price' => $form->order->subtotal_price * $deposit_amount / 100,
                    'total_price' => $form->order->total_price * $deposit_amount / 100,
                    'shipping_cost' => $form->order->shipping_cost * $deposit_amount / 100,
                    'tax' => ($form->order->subtotal_price * $form->order->tax / 100) * $deposit_amount / 100,
                ];

                $main_totals = [
                    'base_price' => $form->order->base_price * (100 - $deposit_amount) / 100,
                    'discount_amount' => $form->order->discount_amount * (100 - $deposit_amount) / 100,
                    'subtotal_price' => $form->order->subtotal_price * (100 - $deposit_amount) / 100,
                    'total_price' => $form->order->total_price * (100 - $deposit_amount) / 100,
                    'shipping_cost' => $form->order->shipping_cost * (100 - $deposit_amount) / 100,
                    'tax' => ($form->order->subtotal_price * $form->order->tax / 100) * (100 - $deposit_amount) / 100,
                ];
            } else {
                $deposit_amount = 0;
                $deposit_totals = [];
                $main_totals = [
                    'base_price' => $form->order->base_price,
                    'discount_amount' => $form->order->discount_amount,
                    'subtotal_price' => $form->order->subtotal_price,
                    'total_price' => $form->order->total_price,
                    'shipping_cost' => $form->order->shipping_cost,
                    'tax' => ($form->order->subtotal_price * $form->order->tax / 100),
                ];
            }

            $all_totals = [
                (string) $deposit_amount => $deposit_totals, 
                (string) (100 - (float) $deposit_amount) => $main_totals
            ];


            // TODO: Try to load TenantSettings somehow, it's not working (not getting the data from `tenant_settings` table)...
            // dispatch(function() use($all_totals) {
                DB::beginTransaction();

                try {
                    $form->saveOrder();

                    foreach($all_totals as $percentage_of_total => $totals) {
                        if(!empty($totals)) {
                            $percentage_of_total = (float) $percentage_of_total;

                            $invoice = new Invoice();

                            $invoice->mode = 'live';
                            $invoice->is_temp = false;
            
                            // Make this changable in modal (when generate invoice is clicked)
                            $invoice->payment_method_type = (Payments::wire_transfer())::class;
                            $invoice->payment_method_id = Payments::wire_transfer()->id;
                
                            $invoice->order_id = $form->order->id;
                            $invoice->shop_id = $form->order->shop_id;
                            $invoice->user_id = $form->order->user_id;
                            $invoice->payment_status = PaymentStatusEnum::unpaid()->value;
                            $invoice->setInvoiceNumber();
                
                            $invoice->email = $form->order->email;
                            $invoice->billing_first_name = $form->order->billing_first_name;
                            $invoice->billing_last_name = $form->order->billing_last_name;
                            $invoice->billing_company = $form->order->billing_company;
                            $invoice->billing_address = $form->order->billing_address;
                            $invoice->billing_country = $form->order->billing_country;
                            $invoice->billing_state = $form->order->billing_state;
                            $invoice->billing_city = $form->order->billing_city;
                            $invoice->billing_zip = $form->order->billing_zip;
                
                            // TODO: add base_currency for invoice! and take it from stripe!
                
                            $invoice->start_date = $form->order->created_at->timestamp;
                            $invoice->end_date = 0;
                
                            $invoice->base_price = $totals['base_price'];
                            $invoice->discount_amount = $totals['discount_amount'];
                            $invoice->subtotal_price = $totals['subtotal_price'];
                            $invoice->total_price = $totals['total_price'];
                            $invoice->shipping_cost = $totals['shipping_cost'];
                            $invoice->tax = $totals['tax'];
                
                            $invoice->note = $form->order->note;
                
                            $user = $form->order->user;

                            $customer_entity = $form->wef['billing_entity'] ?? $user->entity;

                            if($customer_entity === 'company') {
                                $invoice->mergeData([
                                    'customer' => [
                                        'entity' => $customer_entity,
                                        'vat' => $form->wef['billing_company_vat'] ?? $user->getUserMeta('company_vat'),
                                        'company_registration_number' => $form->wef['billing_company_code'] ?? $user->getUserMeta('company_registration_number'),
                                    ]
                                ]);
                            } else {
                                $invoice->mergeData([
                                    'customer' => [
                                        'entity' => $customer_entity,
                                    ]
                                ]);
                            }

                            // Save pecentage to data column just in case...
                            $invoice->mergeData([
                                'percentage_of_total_order_price' => $percentage_of_total,
                            ]);
                
                            $invoice->save();
            
                            $invoice->setRealInvoiceNumber();

                            $invoice->setWEF('percentage_of_total_order_price', $percentage_of_total);
            
                            // generateInvoicePDF - generate invoice document and 
                            $filepath = $invoice->generateInvoicePDF(save: true);
                            
                            Media::storeAsUploadFromFile($invoice, $filepath, 'invoice_document', file_display_name: translate('Invoice').' '.$invoice->getRealInvoiceNumber());
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    Log::error($e);
                    DB::rollBack();
                    // dd($e);
                    // $form->dispatchGeneralError(translate('There was an error while generating an invoice(s)...Please try again.'));
                    // $form->inform(translate('There was an error while generating an invoice(s)...Please try again.'), '', 'fail');
                }
            // });

            $form->inform(translate('Invoice(s) successfully generated!'), '', 'success');

            return redirect()->route('order.details', $form->order->id);
        }

        $form->dispatchGeneralError(translate('Invoice(s) for this order is already generated.'));
        $form->inform(translate('Invoice(s) for this order is already generated.'), '', 'fail');
    }
}

if (!function_exists('generateInvoicePDF')) {
    function generateInvoicePDF(&$invoice, $custom_title = null, $save = false) {
        $shop = $invoice->shop;
        $user = $invoice->user;

        $business = new Party([
            'name'          => get_tenant_setting('company_name'),
            // 'phone'         => is_array($shop->phones) ? implode(',', $shop->phones) : '',
            'custom_fields' => [
                'address' => get_tenant_setting('company_address'),
                'city' => get_tenant_setting('company_city'),
                'country' => get_tenant_setting('company_country'),
                'postal code' => get_tenant_setting('company_postal_code'),
                'email' => get_tenant_setting('company_email'),
                'VAT no.' => get_tenant_setting('company_vat'),
                'Company no.' => get_tenant_setting('company_number'),
            ],
        ]);

        $notes = [];

        $customer_custom_fields = [
            'name' => $invoice->billing_first_name.' '.$invoice->billing_last_name,
        ];
        $customer_entity = $invoice->getData('customer.entity');

        if($customer_entity === UserEntityEnum::company()->value) {
            // Company
            $company_country = $invoice->billing_country;
            $company_vat = $invoice->getData('customer.vat');
            $company_registration_number = $invoice->getData('customer.company_registration_number');

            $customer_custom_fields = array_merge($customer_custom_fields, [
                'company' => $invoice->billing_company ?? '',
                'company no.' => $company_registration_number,
                'VAT no.' => $company_vat,
            ]);
        }

        $customer_custom_fields = array_merge($customer_custom_fields, [
            'address' => $invoice->billing_address.', '.$invoice->billing_zip,
            'city' => $invoice->billing_city,
            'country' => Countries::get(code: $invoice->billing_country)?->name ?? $invoice->billing_country,
            'email' => $invoice->email,
            'order number' => '#'.$invoice->order->id,
        ]);

        $customer = new Party([
            'custom_fields' => $customer_custom_fields,
        ]);
        

        /**
         * Important: There are two levels of discounts:
         * 1. Discouts on order_items level - for example: yearly discount etc.
         * 2. Discounts on order/invoice level - for example: coupon etc.
         * 
         * IMPORTANT: getDiscountAmount() - gets all discounts applied to the current invoice
         * In order to get discounts on order/invoice level, we must subtract 1. from getDiscountAmount()
         * 
         * TODO: Find a better way to manage and calculate discounts on these levels!!!
         */
        $invoice_items = [];
        $sum_invoice_items_discounts = 0; // Sum of all discounts on invoice items level!
        $percentage_of_total_order_price = $invoice->getWEF('percentage_of_total_order_price', ad_hoc_data_type: 'decimal') ?? 100;

        if(!empty($invoice->order->order_items)) {
            foreach($invoice->order->order_items as $item) {
                $invoice_items[] = (new InvoiceItem())
                    ->title($item->name)
                    ->description($item->excerpt ?? '')
                    ->pricePerUnit($item->base_price * $percentage_of_total_order_price / 100)
                    ->quantity($item->quantity)
                    ->discount(($item->discount_amount ?? 0) * $percentage_of_total_order_price / 100)
                    ->subTotalPrice((($item->base_price * $percentage_of_total_order_price / 100) * $item->quantity) - $item->discount_amount);
    
                $sum_invoice_items_discounts += ($item->discount_amount ?? 0) * $percentage_of_total_order_price / 100;
            }
        }

        $order_level_discount = $invoice->getDiscountAmount(false) - $sum_invoice_items_discounts;

        $total_taxes_label = 'VAT ('.(int) get_tenant_setting('company_tax_rate').'%)';

        // Set custom invoice data
        $custom_data = [
            'total_discount' => $order_level_discount > 0.5 ? $order_level_discount : 0,
            'total_taxes_label' => $total_taxes_label,
            'via_payment_method' => function() use($invoice) {
                return Payments::getViaLabel($invoice);
            },
            'taxable_amount' => TaxService::isTaxIncluded() ? ($invoice->total_price - TaxService::calculateTaxAmount($invoice->total_price)) : null,
            'taxes_amount' => TaxService::isTaxIncluded() ? TaxService::calculateTaxAmount($invoice->total_price) : null,
        ];
        
        // Create PDF with $invoice data and stream it
        $invoice_title = !empty($custom_title) ? $custom_title : translate('Invoice').' #'.$invoice->id;
        $invoice_filename = (!empty($custom_title) ? \Str::slug($custom_title) : translate('Invoice')).'_'.$invoice->getRealInvoiceNumber();

        $pdf = LaravelInvoice::make($invoice_title)
            ->series(!empty($invoice->real_invoice_number) ? $invoice->getRealInvoiceNumber() : $invoice->invoice_number)
            // ->sequence()
            ->serialNumberFormat('{SERIES}')
            // ability to include translated invoice status
            // in case it was paid
            ->filename($invoice_filename)
            ->status($invoice->payment_status)
            ->seller($business)
            ->buyer($customer)
            ->date($invoice->created_at)
            ->dateFormat('d M, Y')
            ->payUntilDays(!empty($invoice->due_date) ? $invoice->created_at->diffInDays(Carbon::createFromTimestamp($invoice->due_date)) : 0)
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->addItems($invoice_items)
            ->setCustomData($custom_data)
            ->notes(implode(', ', $notes));

        if($save) {
            $invoice_path = Media::getTenantPath('invoices').'/'.(!empty($invoice->real_invoice_number) ? $invoice->getRealInvoiceNumber() : $invoice->invoice_number);

            $pdf
                ->filename($invoice_path)
                ->save(config('filesystems.default'));

            return $invoice_path.'.pdf';
        }

        if($invoice->tax > 0 && !TaxService::isTaxIncluded()) {
            $pdf->totalTaxes($invoice->tax);
        }

        return $pdf->stream();
    }
}