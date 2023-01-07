<?php

namespace App\Http\Services\Stripe;

use \Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\ForwardsCalls;

use App\Http\Services\Stripe\Traits\Webhooks\WebhookMagics;
use App\Http\Services\Stripe\Traits\Webhooks\InvoiceWebhooks;
use App\Http\Services\Stripe\Traits\Webhooks\CustomerWebhooks;
use App\Http\Services\Stripe\Traits\Webhooks\CheckoutSessionWebhooks;
use App\Http\Services\Stripe\Traits\Webhooks\CustomerSubscriptionWebhooks;

class StripeWebhooks
{   
    use ForwardsCalls;
    use WebhookMagics;
    use CustomerWebhooks;
    use CheckoutSessionWebhooks;
    use CustomerSubscriptionWebhooks;
    use InvoiceWebhooks;

    // WEBHOOKS
    public function processWebhooks(?Request $request = null)
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = Payments::isStripeLiveMode() ? Payments::stripe()->stripe_webhook_live_secret : Payments::stripe()->stripe_webhook_test_secret;

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            print_r($e);
            http_response_code(400);
            die();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            print_r($e);
            http_response_code(400);
            die();
        }

        // Handle the event
        switch ($event->type) {
            case 'customer.created':
                $this->whCustomerCreated($event);
                break;
            case 'customer.updated':
                $this->whCustomerUpdated($event);
                break;
            case 'charge.succeeded':
                // $this->whChargeSucceeded($event);
                break;
            case 'checkout.session.completed':
                $this->whCheckoutSessionCompleted($event);
                break;
            case 'checkout.session.expired':
                $this->whCheckoutSessionExpired($event);
                break;
            case 'invoice.created':
                $this->whInvoiceCreated($event);
                break;
            case 'invoice.paid':
                $this->whInvoicePaid($event);
                break;
            case 'invoice.payment_failed':
                $this->whInvoicePaymentFailed($event);
                break;
            case 'invoice.payment_succeeded':
                // $paymentIntent = $event->data->object;
                break;
            case 'invoice.upcoming':
                // TODO: Check when this one fires and store upcoming invoice data somewhere!!!!
                break;
            case 'payment_intent.created':
                break;
            case 'payment_intent.canceled':
                break;
            case 'payment_intent.succeeded':
                // $this->whPaymentIntentSucceeded($event);
                break;
            case 'customer.subscription.created':
                $this->whCustomerSubscriptionCreated($event);
                break;
            case 'customer.subscription.updated':
                $this->whCustomerSubscriptionUpdated($event);
                break;
            case 'customer.subscription.deleted':
                $this->whCustomerSubscriptionDeleted($event);
                break;

                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
        die();
    }
}