<?php

namespace App\Http\Services\PaymentMethods;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use EVS;
use FX;
use WebToPay;

class PayseraGateway
{
    public $payment_method;
    public $order;
    public $invoice;
    public $lang;
    public $paytext;
    public $accepturl;
    public $cancelurl;
    public $callbackurl;
    public $test;

    public function __construct(?Order $order = null, ?Invoice $invoice = null, mixed $payment_method = null, $lang = null, $paytext = '') {
        try {
            $this->payment_method = ($payment_method instanceof PaymentMethodUniversal || $payment_method instanceof PaymentMethod)
                ? $payment_method : PaymentMethodUniversal::where('gateway', 'paysera')->first();

            $this->order = $order;
            $this->invoice = $invoice;
            $this->lang = !empty($lang) ? $lang : 'ENG'; // TODO: Get current user selected language from the Session. But remember to use ISO 639-2/B notation!!!
            $this->paytext = !empty($paytext) ? $paytext : translate('Payment for goods and services (for nb. [order_nr]) ([site_name])'); // MUST USE: [order_nr] and ([site_name] or [owner_name] )
            $this->test = 1; // Testing!

            $this->accepturl = route('gateway.paysera.accepted', ['invoice_id' => $this->invoice->id]);
            $this->cancelurl = route('gateway.paysera.canceled', ['invoice_id' => $this->invoice->id]);
            $this->callbackurl = route('gateway.paysera.callback', ['invoice_id' => $this->invoice->id]);
        } catch(\Exception $e) {}
    }

    public function pay() {
        try {
            WebToPay::redirectToPayment([
                'projectid' => $this->payment_method->paysera_project_id,
                'sign_password' => $this->payment_method->paysera_project_password,
                'orderid' => $this->invoice->id,
                'amount' => $this->invoice->total_price * 100, // in cents, hence x100
                'currency' => 'EUR', // 3-char notation - EUR, USD, RSD, JPY etc. TODO: Add currency column to `orders` table
                'country' => $this->invoice->billing_country, // 2-char notation - LT, GB, US, DE, PL, RS etc.
                'lang' => $this->lang,
                'paytext' => $this->paytext,
                'name' => $this->invoice->billing_first_name,
                'surename' => $this->invoice->billing_last_name,
                'p_firstname' => $this->invoice->billing_first_name,
                'p_lastname' => $this->invoice->billing_last_name,
                'p_email' => $this->invoice->email,
                'p_street' => !empty($this->order->shipping_address) ? $this->order->shipping_address : $this->order->billing_address,
                'p_city' => !empty($this->order->shipping_city) ? $this->order->shipping_city : $this->order->billing_city,
                'p_state' => !empty($this->order->shipping_state) ? $this->order->shipping_state : $this->order->billing_state,
                'p_zip' => !empty($this->order->shipping_zip) ? $this->order->shipping_zip : $this->order->billing_zip,
                'p_countrycode' => !empty($this->order->shipping_country) ? $this->order->shipping_country : $this->order->billing_country,
                'buyer_consent' => 1,
                'accepturl' => $this->accepturl,
                'cancelurl' => $this->cancelurl,
                'callbackurl' => $this->callbackurl,
                'test' => $this->test,
            ]);
        } catch (\Exception $exception) {
            dd( get_class($exception) . ':' . $exception->getMessage());
        }
    }

    public function accepted(Request $request, $invoice_id) {
        $params = array();
        parse_str( base64_decode( strtr( $request->data, array( '-' => '+', '_' => '/' ) ) ), $params );

        $invoice = Invoice::find($invoice_id);

        $invoice->order->payment_status = $invoice->isLastInvoice() ? PaymentStatusEnum::pending()->value : PaymentStatusEnum::unpaid()->value;
        $invoice->meta = $params;
        $invoice->payment_status = PaymentStatusEnum::pending()->value; // change payment status to pending until callback from paysera changes it to `paid`

        $invoice->order->save();
        $invoice->save();

        return view('frontend.order-accepted', compact('order'));
    }

    public function canceled(Request $request, $invoice_id) {
        $invoice = Invoice::find($invoice_id);

        $invoice->order->payment_status = PaymentStatusEnum::unpaid()->value; // change payment status of Order to unpaid
        $invoice->payment_status = PaymentStatusEnum::canceled()->value; // change payment_status of Invoice to canceled

        $invoice->order->save();
        $invoice->save();

        return view('frontend.order-canceled', compact('order'));
    }

    public function callback(Request $request, $invoice_id) {
        $invoice = Invoice::find($invoice_id);

        try {
            $response = WebToPay::validateAndParseData(
                $_REQUEST,
                $invoice->payment_method->paysera_project_id,
                $invoice->payment_method->paysera_project_password
            );

            if ($response['status'] === '1' || $response['status'] === '3') {
                // ToDo: Validate payment amount and currency, example provided in isPaymentValid method.

                if((int) $response['orderid'] !== Invoice::findOrFail($response['orderid'])->id) {
                    Log::debug(translate('Received orderid from Paysera callback is not the same as an invoice in DB'));
                    throw new \Exception(translate('Received orderid from Paysera callback is not the same as an invoice in DB'));
                }

                $this->isPaymentValid($invoice, $response); // check if payment is valid

                $invoice->payment_status = PaymentStatusEnum::paid()->value; // change payment status
                $invoice->save();

                $invoice->order->payment_status = $invoice->isLastInvoice() ? PaymentStatusEnum::paid()->value : PaymentStatusEnum::unpaid()->value;
                $invoice->order->save();

                echo 'OK';
            } else {
                Log::debug(translate('Payment was not successful for invoice: #'.$invoice->id));
                throw new \Exception(translate('Payment was not successful for invoice: #'.$invoice->id));
            }
        } catch (\Exception $exception) {
            echo get_class($exception) . ':' . $exception->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    protected function isPaymentValid(Invoice $invoice, array $response): bool
    {
        if (array_key_exists('payamount', $response) === false) {
            if ($invoice->total_price !== (float) $response['amount']) { // TODO: Check currency also
                Log::debug(translate('Wrong payment amount for invoice: #'.$invoice->id.' ('.$invoice->total_price.' != '.$response['amount'].')'));
                throw new \Exception('Wrong payment amount for invoice: #'.$invoice->id.' ('.$invoice->total_price.' != '.$response['amount'].')');
            }
        } else if ($invoice->total_price !== (float) $response['payamount']) { // TODO: Check currency also
            Log::debug(translate('Wrong payment amount for order: #'.$invoice->id.' ('.$invoice->total_price.' != '.$response['payamount'].')'));
            throw new \Exception('Wrong payment amount for order: #'.$invoice->id.' ('.$invoice->total_price.' != '.$response['payamount'].')');
        }

        return true;
    }
}
