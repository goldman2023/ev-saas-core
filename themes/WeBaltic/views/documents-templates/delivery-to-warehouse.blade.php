@extends('documents-templates.global-pdf-layout.pdf-layout')

@push('styles')
<style>

</style>
@endpush

@section('content')

<div class="watermark">

</div>
<div class="text-sm py-3">
  <div class="w-full text-lg font-bold text-center pb-6">
      Delivery Note
  </div>

  <div class="w-full pb-1">
    <span class="font-bold">Delivery No:</span> {{ get_delivery_document_number($upload) }}
  </div>
  <div class="w-full pb-1">
    <span class="font-bold">Delivery initiated:</span> 
    {{ empty($order->getWEF('cycle_step_date_delivery_to_warehouse')) ? '' : \Carbon::createFromTimestamp($order->getWEF('cycle_step_date_delivery_to_warehouse'))->format('Y-m-d H:i') }}
  </div>

  <div class="w-full pb-6">
    <span class="font-bold">Deliery type:</span> To warehouse
  </div>

  <div class="w-full pb-1">
    <span class="font-bold">Order reference:</span> #{{ $order->id }}
  </div>
  <div class="w-full pb-6">
    <span class="font-bold">Order date:</span> {{ $order->created_at->format('Y-m-d H:i') }}
  </div>


  {{-- Order Items --}}
  <div class="w-full pb-3">
    <span class="font-bold">Order Items</span>
  </div>
  <div class="w-full pb-4">
    @if($order->order_items->isNotEmpty())
      <table class="table-border w-full table-auto text-sm" style="border-spacing: 20px 0;">
          <thead>
            <tr class="text-left">
              <th align="left" class="pl-2">ID</th>
              <th align="left" class="pl-2">Name</th>
              <th align="left" class="pl-2">Quantity</th>
            </tr>
          </thead>
          <tbody class="">
            @foreach($order->order_items as $item)
              <tr>
                <td class="pr-2 pl-2">{{ $item->id }}</td>
                <td class="pr-2 pl-2">{{ $item->name }}</td>
                <td class="pr-2 pl-2">{{ $item->quantity }}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
    @endif
  </div>

  <div class="w-full pb-6">
      <span class="font-bold">Total Weight:</span>  {{ $order->order_items->first()->getAttrValue('priekabos-eksplotacine-mase') }} kg
  </div>

  <div class="w-full pb-3">
      <span class="font-bold">Notes</span>
  </div>

  <div class="w-full border border-gray-400 p-3 min-h-60">
    {{-- Upload `delivery_to_warehouse_notes` wef --}}
    @if(!empty($proposal_notes = $upload->getWEF('delivery_to_warehouse_notes', true, 'array')))
      <ul class="list-disc pl-5">
          @foreach($proposal_notes as $note)
              <li>{{ $note }}</li>
          @endforeach
      </ul>
    @endif
  </div>
</div>

@endsection