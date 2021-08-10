@extends('backend.layouts.app')

@section('content')
@php
    $refund_request_addon = \App\Models\Addon::where('unique_identifier', 'refund_request')->first();
@endphp
<div class="card">
    <form class="" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('All Orders') }}</h5>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Order Code') }}</th>
                    <th data-breakpoints="md">{{ translate('Num. of Products') }}</th>
                    <th data-breakpoints="md">{{ translate('Customer') }}</th>
                    <th data-breakpoints="md">{{ translate('Amount') }}</th>
                    <th data-breakpoints="md">{{ translate('Delivery Status') }}</th>
                    <th data-breakpoints="md">{{ translate('Payment Status') }}</th>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <th>{{ translate('Refund') }}</th>
                    @endif
                    <th class="text-right" width="15%">{{translate('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                <tr>
                    <td>
                        {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                    </td>
                    <td>
                        {{ $order->code }}
                    </td>
                    <td>
                        {{ count($order->orderDetails) }}
                    </td>
                    <td>
                        @if ($order->user != null)
                        {{ $order->user->name }}
                        @else
                        Guest ({{ $order->guest_id }})
                        @endif
                    </td>
                    <td>
                        {{ single_price($order->grand_total) }}
                    </td>
                    <td>
                        @php
                            $status = 'Delivered';
                            foreach ($order->orderDetails as $key => $orderDetail) {
                                if($orderDetail->delivery_status != 'delivered'){
                                    $status = translate('Pending');
                                } if($orderDetail->delivery_status == 'cancelled') {
                                    $status = '<span class="badge badge-inline badge-danger">'.translate('Cancel').'</span>';
                                }
                            }
                        @endphp
                        {!! $status !!}
                    </td>
                    <td>
                        @if ($order->payment_status == 'paid')
                        <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                        @else
                        <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                        @endif
                    </td>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <td>
                        @if (count($order->refund_requests) > 0)
                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                        @else
                        {{ translate('No Refund') }}
                        @endif
                    </td>
                    @endif
                    <td class="text-right">
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.all_orders.show', $order->id)}}" title="{{ translate('View') }}">
                            <i class="las la-eye"></i>
                        </a>
                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                            <i class="las la-download"></i>
                        </a>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links() }}
        </div>

    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
