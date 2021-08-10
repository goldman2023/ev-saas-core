@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="page-header border-0 pb-0 my-3">
            <div class="row align-items-center">
                <div class="col-sm">
                    <h1 class="page-header-title">{{ translate('Notifications') }}</h1>                    
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
                    <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer" style="width: 100%;" data-hs-datatables-options="{
                        columnDefs: [{
                            targets: [0],
                            orderable: false
                        }],
                        order: [],
                        pageLength: 12,
                        isResponsive: false,
                        isShowPaging: false
                    }" role="grid" aria-describedby="datatable_info">
                        <thead class="thead-light">
                            <tr role="row">
                                <th scope="col" class="table-column-pr-0 sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 24px;">
                                    <div class="custom-control custom-checkbox">
                                        <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label" for="datatableCheckAll"></label>
                                    </div>
                                </th>
                                <th class="table-column-pl-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Order: activate to sort column ascending" style="width: 69px;">{{ translate('No') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 155px;">{{ translate('Date') }}</th>
                                <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" style="width: 128px;">{{ translate('Title') }}</th>
                                {{-- <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 104px;">{{ translate('Actions') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $index => $notification)
                                @php
                                    $user = \App\Models\User::where('id', $notification->data['subject_id'])->first();
                                @endphp
                                <tr role="row">
                                    <td class="table-column-pr-0">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="{{ 'notification' . $notification->id }}">
                                            <label class="custom-control-label" for="{{ 'notification' . $notification->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="table-column-pl-0"> {{ $index + 1 }}</td>
                                    <td>{{ $notification->created_at }}</td>
                                    <td> <a class="text-body" target="_blank" href="{{ route('shop.visit', $user->shop->slug) }}">{{ $notification->data['message'] }}</a> </td>
                                    {{-- <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-sm btn-white" href="#"> <i class="tio-visible-outlined"></i> {{ translate('View') }} </a>
                                            <!-- Unfold -->
                                            <div class="hs-unfold btn-group">
                                                <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-white dropdown-toggle dropdown-toggle-empty" href="javascript:;" data-hs-unfold-options='{
                                                    "target": "#ordersExportDropdown1",
                                                    "type": "css-animation",
                                                    "smartPositionOffEl": "#datatable"
                                                }' data-hs-unfold-target="#ordersExportDropdown1" data-hs-unfold-invoker=""></a>
                                                <div id="ordersExportDropdown1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1 hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated" data-hs-target-height="324" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut" style="animation-duration: 300ms;"> <span class="dropdown-header">Options</span>
                                                    <a class="dropdown-item" href="javascript:;"> <i class="tio-delete-outlined dropdown-item-icon"></i> Delete </a>
                                                </div>
                                            </div>
                                            <!-- End Unfold -->
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Table -->
            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection