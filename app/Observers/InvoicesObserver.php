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
    public $afterCommit = true;

    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        // Fire only if Invoice is not temporary and price is bigger than 0!
        if(!$invoice->is_temp && $invoice->getRealTotalPrice(format: false) > 0) {
            try {
                $invoice->user->notify(new InvoiceCreated($invoice));
                $invoice->setData('invoice_created_email_sent', true);
                $invoice->saveQuietly();
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
        if(!$invoice->is_temp && $invoice->getData('invoice_created_email_sent') !== true && $invoice->getRealTotalPrice(format: false) > 0) {
            try {
                $invoice->user->notify(new InvoiceCreated($invoice));
                $invoice->setData('invoice_created_email_sent', true);
                $invoice->saveQuietly();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
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
