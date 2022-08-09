@component('mail::message')
# New Invoice
 
@lang('New invoice has been issued: #') {{ $invoice->getRealInvoiceNumber() }} 

@component('mail::table')
| # | ID | Item name | Price | Quantity | Total
| :-- | :-- | :-- | :-- | :-- | :-- |
@foreach ($invoice->order->order_items as $index => $order_item)
| {{ $index }} | {{ $order_item->id }} | {{ $order_item->name }} | {{ \FX::formatPrice($order_item->total_price / $order_item->quantity) }} | {{ $order_item->quantity }} | {{ \FX::formatPrice($order_item->total_price) }} |
@endforeach
@endcomponent

@component('mail::panel')
@if($invoice->isFromStripe())
    @php
        $stripe_invoice = $invoice->getData(stripe_prefix('stripe_invoice_data'));
    @endphp

    @if(!empty($stripe_invoice))
        <strong>Subtotal:</strong> <span>{{ \FX::formatPrice($stripe_invoice['total_excluding_tax'] / 100) }}</span> <br>
        <strong>Tax:</strong> <span>{{ \FX::formatPrice($stripe_invoice['tax'] / 100) }}</span> <br>
        <strong>Total:</strong> <span>{{ $invoice->getRealTotalPrice() }}</span> <br>
    @endif
@else
    <strong>Subtotal:</strong> <span>{{ \FX::formatPrice($invoice->subtotal_price) }}</span> <br>
    <strong>Tax:</strong> <span>{{ \FX::formatPrice($invoice->tax) }}</span> <br>
    <strong>Total:</strong> <span>{{ $invoice->getRealTotalPrice() }}</span> <br>
@endif
@endcomponent


 
@component('mail::button', ['url' => $invoice->order->getPermalink()])
@lang('View Invoice')
@endcomponent
 
@lang('Regards'),<br>
{{ get_tenant_setting('site_name') }}
@endcomponent