<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Mail\InvoiceCreatedEmail;
use Illuminate\Support\Facades\Mail;
use App\Enums\PaymentStatusEnum;
use Log;

class InvoicesObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        try {
            Mail::to($invoice->user->email)
                    ->send(new InvoiceCreatedEmail($invoice));

            $meta = $invoice->meta;
            $meta['invoice_created_email_sent'] = true;
            $invoice->meta = $meta;
            $invoice->save();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        try {
            if($invoice->payment_status === PaymentStatusEnum::paid()->value) {
                Mail::to($invoice->user->email)
                        ->send(new InvoicePaidEmail($invoice));
            }
            
            $meta = $invoice->meta;
            $meta['invoice_paid_email_sent'] = true;
            $invoice->meta = $meta;
            $invoice->save();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
