@component('mail::message')
# New Invoice
 
@lang('New invoice has been issued: #') {{ $invoice->id }} 

@component('mail::table')
| # | ID | Item name | Price | Quantity | Total
| :-- | :-- | :-- | :-- | :-- | :-- |
@foreach ($invoice->order->order_items as $index => $order_item)
| {{ $index }} | {{ $order_item->id }} | {{ $order_item->name }} | {{ \FX::formatPrice($order_item->total_price / $order_item->quantity) }} | {{ $order_item->quantity }} | {{ \FX::formatPrice($order_item->total_price) }} |
@endforeach
@endcomponent

<strong>Subtotal:</strong> <span>{{ \FX::formatPrice($invoice->order->subtotal_price) }}</span> <br>
<strong>Tax:</strong> <span>{{ \FX::formatPrice($invoice->order->tax) }}</span> <br>
<strong>Total:</strong> <span>{{ \FX::formatPrice($invoice->order->total_price) }}</span> <br>
 
@component('mail::button', ['url' => $invoice->order->getPermalink()])
@lang('View Invoice')
@endcomponent
 
@lang('Regards'),<br>
{{ get_tenant_setting('site_name') }}
@endcomponent