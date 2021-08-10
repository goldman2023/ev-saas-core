       @php
           $date = date('Y-m-d');
           $days_ago_30 = date('Y-m-d', strtotime('-30 days', strtotime($date)));
           $days_ago_60 = date('Y-m-d', strtotime('-60 days', strtotime($date)));
       @endphp
       <h4 class="h5 fw-600 text-center">{{ translate('Sold Amount') }}</h4>
       <div class="widget-balance pb-3 pt-1 ">
           <div class="text-center">
               <div class="heading-4 strong-700 mb-4">
                   @php
                       $orderTotal = \App\Models\Order::where('seller_id', auth()->user()->id)
                           ->where('payment_status', 'paid')
                           ->where('created_at', '>=', $days_ago_30)
                           ->sum('grand_total');
                       //$orderDetails = \App\Models\OrderDetail::where('seller_id', auth()->user()->id)->where('created_at', '>=', $days_ago_30)->get();
                       //$total = 0;
                       //foreach ($orderDetails as $key => $orderDetail) {
                       //if($orderDetail->order != null && $orderDetail->order != null && $orderDetail->order->payment_status == 'paid'){
                       //$total += $orderDetail->price;
                       //}
                       //}
                   @endphp
                   <small class="d-block fs-12 mb-2">{{ translate('Your sold amount (current month)') }}</small>
                   <span class="btn btn-primary fw-600 fs-18">{{ single_price($orderTotal) }}</span>
               </div>
               <table class="table table-borderless d-none">
                   <tr>
                       @php
                           $orderTotal = \App\Models\Order::where('seller_id', auth()->user()->id)
                               ->where('payment_status', 'paid')
                               ->sum('grand_total');
                       @endphp
                       <td class="p-1" width="60%">
                           {{ translate('Total Sold') }}:
                       </td>
                       <td class="p-1 fw-600" width="40%">
                           {{ single_price($orderTotal) }}
                       </td>
                   </tr>
                   <tr>
                       @php
                           $orderTotal = \App\Models\Order::where('seller_id', auth()->user()->id)
                               ->where('payment_status', 'paid')
                               ->where('created_at', '>=', $days_ago_60)
                               ->where('created_at', '<=', $days_ago_30)
                               ->sum('grand_total');
                       @endphp
                       <td class="p-1" width="60%">
                           {{ translate('Last Month Sold') }}:
                       </td>
                       <td class="p-1 fw-600" width="40%">
                           {{ single_price($orderTotal) }}
                       </td>
                   </tr>
               </table>
           </div>
           <table>

           </table>
       </div>
