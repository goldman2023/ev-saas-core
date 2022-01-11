@extends('frontend.layouts.user_panel')

@section('panel_content')


<div class="card d-flex flex-row justify-content-start pl-3 py-3 align-items-center mb-3">
    <h2 class="h3 d-flex align-items-center my-0">

        <span> {{ translate('Your products') }}</span>
    </h2>
</div>
<div class="row">
    <div class="col-8">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <x-default.dashboard.customer.current-plan>
                    @slot('title')
                        AdeoWeb - Headache Free Website
                    @endslot

                    @slot('image')
                    <img src="https://images.ev-saas.com/insecure/fill/1200/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/95729fac-ae52-44ea-824e-b634d8100c54/1641824421_Screenshot%202022-01-10%20at%2013.46.00.png@webp" />
                    @endslot
                </x-default.dashboard.customer.current-plan>
            </div>

        <div class="col-sm-6 mb-3">
            <x-default.dashboard.customer.current-plan>
                @slot('title')
                PassCamp - Headache Free Website
                @endslot

                @slot('image')
                <img src="https://images.ev-saas.com/insecure/fill/1200/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/95729fac-ae52-44ea-824e-b634d8100c54/1641824541_Screenshot%202022-01-10%20at%2016.22.00.png@webp" />
                @endslot

            </x-default.dashboard.customer.current-plan>



        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                        <div class="card">
                            <!-- Header -->
                            <div class="card-header">
                                <h5 class="card-header-title">Your Invoices</h5>
                            </div>
                            <!-- End Header -->

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Updated</th>
                                            <th>Invoice</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><a href="#">#3682303</a></td>
                                            <td><span class="badge bg-soft-warning text-warning">Pending</span></td>
                                            <td>$264</td>
                                            <td>22/04/2020</td>
                                            <td><a class="btn btn-white btn-xs" href="./page-invoice.html"><i
                                                        class="bi-file-earmark-arrow-down-fill me-1"></i> PDF</a></td>
                                            <td><a class="btn btn-white btn-xs" href="javascript:;" data-bs-toggle="modal"
                                                    data-bs-target="#accountInvoiceReceiptModal"><i class="bi-eye-fill me-1"></i> Quick
                                                    view</a></td>
                                        </tr>

                                        <tr>
                                            <td><a href="#">#2333234</a></td>
                                            <td><span class="badge bg-soft-success text-success">Successful</span></td>
                                            <td>$264</td>
                                            <td>22/04/2019</td>
                                            <td><a class="btn btn-white btn-xs" href="./page-invoice.html"><i
                                                        class="bi-file-earmark-arrow-down-fill me-1"></i> PDF</a></td>
                                            <td><a class="btn btn-white btn-xs" href="javascript:;" data-bs-toggle="modal"
                                                    data-bs-target="#accountInvoiceReceiptModal"><i class="bi-eye-fill me-1"></i> Quick
                                                    view</a></td>
                                        </tr>

                                        <tr>
                                            <td><a href="#">#9834283</a></td>
                                            <td><span class="badge bg-soft-success text-success">Successful</span></td>
                                            <td>$264</td>
                                            <td>22/04/2018</td>
                                            <td><a class="btn btn-white btn-xs" href="./page-invoice.html"><i
                                                        class="bi-file-earmark-arrow-down-fill me-1"></i> PDF</a></td>
                                            <td><a class="btn btn-white btn-xs" href="javascript:;" data-bs-toggle="modal"
                                                    data-bs-target="#accountInvoiceReceiptModal"><i class="bi-eye-fill me-1"></i> Quick
                                                    view</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>





    <div class="col-sm-4">
         <x-default.dashboard.customer.support-agent>
         </x-default.dashboard.customer.support-agent>
        <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body">
                  <h3 class="text-hover-primary mb-1">✅ New Task</h3>
                  <span class="text-body">Create a new task for our development team</span>
                </div>

                <div class="ml-2 text-right">
                  <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                </div>
              </div>
              <!-- End Row -->
            </div>
          </a>

          <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body">
                  <h3 class="text-hover-primary mb-1">🗓️ Book A Meeting</h3>
                  <span class="text-body">Book a meeting with your project manager</span>
                </div>

                <div class="ml-2 text-right">
                  <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                </div>
              </div>
              <!-- End Row -->
            </div>
          </a>

          <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body">
                  <h3 class="text-hover-primary mb-1">ℹ️ Knowledge Base</h3>
                  <span class="text-body">All the links and all the answers to your questions</span>
                </div>

                <div class="ml-2 text-right">
                  <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                </div>
              </div>
              <!-- End Row -->
            </div>
          </a>





        </div>



</div>




@endsection
