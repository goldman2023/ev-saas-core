<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Mail\InvoiceCreatedEmail;
use App\Mail\InvoicePaidEmail;
use Illuminate\Support\Facades\Mail;
use App\Enums\PaymentStatusEnum;
use App\Notifications\Invoice\InvoiceCreated;
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
        // Fire only if Invoice is not temporary!
        if(!$invoice->is_temp) {
            try {
                $invoice->user->notify(new InvoiceCreated($invoice));
                $invoice->setData('invoice_created_email_sent', true);
                $invoice->save();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
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
        if(!$invoice->is_temp && !$invoice->getData('invoice_created_email_sent')) {
            try {
                $invoice->user->notify(new InvoiceCreated($invoice));
                $invoice->setData('invoice_created_email_sent', true);
                $invoice->save();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
                die(print_r($e));
            }
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
