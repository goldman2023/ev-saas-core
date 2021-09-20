@extends('frontend.layouts.user_panel')
@section('page_title', translate('Leads'))

@section('panel_content')
    <div class="row">
        <div class="col-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                  <h6 class="card-subtitle mb-2">{{ translate('Total Leads') }}</h6>

                  <div class="row align-items-center gx-2">
                    <div class="col">
                      <span class="js-counter display-4 text-dark" data-value="24">
                          {{ App\Models\Lead::count() }}
                      </span>
                      <span class="text-body font-size-sm ml-1">{{ translate('from') }} {{ App\Models\Lead::count() }}</span>
                    </div>

                    <div class="col-auto">
                      <span class="badge badge-soft-success p-1">
                        <x-heroicon-o-trending-up class="ev-icon__small" /> {{ App\Models\Lead::trend() }} %
                      </span>
                    </div>
                  </div>
                  <!-- End Row -->
                </div>
              </div>
        </div>
    </div>
    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">
                {{ translate('Leads') }}
            </h5>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>{{ translate('Reference #') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Message') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td><a href="#">#{{ $lead->id }}</a></td>
                        <td><span class="badge badge-soft-warning">Pending</span></td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->message }}</td>
                        <td>{{ $lead->created_at->diffForHumans() }}</td>
                        <td><a class="btn btn-xs btn-white" href="javascript:;" data-toggle="modal"
                                data-target="#invoiceReceiptModal"><i class="fas fa-eye mr-1"></i> Quick view</a></td>
                    </tr>

                    @endforeach


                </tbody>
            </table>
        </div>
        <!-- End Table -->
    </div>
    <!-- End Card -->

    </div>
@endsection
