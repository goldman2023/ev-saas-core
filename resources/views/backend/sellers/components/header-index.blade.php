<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Sellers')}}</h1>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <div class="d-flex align-items-center mr-3">
                <label class="mr-2">{{translate('Switch View')}}</label>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input onchange="switch_view({{ $is_datatable_view }})" type="checkbox" name="is_datatable_view" @if($is_datatable_view == 'true') checked @endif />
                    <span class="slider round"></span>
                </label>
            </div>
            <a href="{{ route('admin.sellers.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Seller')}}</span>
            </a>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">

        function switch_view(is_datatable_view) {

            if (is_datatable_view) {
                window.location.href = '{{ env('APP_URL') }}' + "/admin/sellers";
            }else {
                window.location.href = '{{ env('APP_URL') }}' + "/admin/sellers/data-table";
            }
        }

    </script>
@endsection
