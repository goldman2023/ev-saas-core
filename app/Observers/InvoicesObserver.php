<?php

namespace App\Observers;

use Log;
use App\Models\Invoice;
use App\Mail\InvoicePaidEmail;
use App\Enums\PaymentStatusEnum;
use App\Mail\InvoiceCreatedEmail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\Invoice\InvoiceCreated;
use App\Notifications\UserSubscription\ExtendedSubscription;

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
        $this->sendNotifications($invoice);
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        $this->sendNotifications($invoice);

        if($invoice->getOriginal('payment_status') !== PaymentStatusEnum::paid()->value && 
            $invoice->payment_status === PaymentStatusEnum::paid()->value && 
            empty($invoice->real_invoice_number)) {
            $invoice->setRealInvoiceNumber();
            $invoice->saveQuietly();
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

    private function sendNotifications($invoice) {
        if(!$invoice->is_temp && $invoice->payment_status === 'paid' && $invoice->getData('invoice_created_email_sent') !== true && $invoice->getRealTotalPrice(format: false) > 0) {
            try {
                $invoice->user->notify(new InvoiceCreated($invoice));
                $invoice->setData('invoice_created_email_sent', true);
                $invoice->saveQuietly();
            } catch(\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // Send ExtendedSubscription notification here
        if(!empty($invoice->order->user_subscription)) {

            /* Send subscription extended notification for invoices that are paid and more than 0$ */
            if(!$invoice->is_temp && $invoice->payment_status === 'paid' && !$invoice->getData('subscription_extended_email_sent', false) && $invoice->getRealTotalPrice(format: false) > 0) {
                try {
                    $invoice->user->notify(new ExtendedSubscription($invoice->order->user_subscription));
                    $invoice->setData('subscription_extended_email_sent', true);
                    $invoice->saveQuietly();
                } catch(\Exception $e) {
                    Log::error($e);
                }
            }
        }
    }
}
