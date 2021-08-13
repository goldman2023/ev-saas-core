<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadInvoiceController extends Controller
{
    public function __invoke($id)
    {
        // One approach is to generate invoices ourselves.
        // The disadvantage is that this doesn't show the Stripe client's billing address.

        // return tenant()->downloadInvoice($id, [
        //     'vendor' => 'Foo Inc.',
        //     'product' => 'An Amazing SaaS',
        // ]);

        // For that reason, we use Stripe invoices instead.
        // Feel free to customize this *completely*. This is just an example implementation.
        return redirect(tenant()->findInvoice($id)->asStripeInvoice()->invoice_pdf);
    }
}
