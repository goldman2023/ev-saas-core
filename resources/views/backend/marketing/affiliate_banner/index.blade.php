@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Affiliate Banner')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('admin.affiliate_banner.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Create New Affiliate Banner')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Affiliate Banner')}}</h5>
        <div class="pull-right clearfix">
            <form class="" id="sort_flash_deals" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0" >
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Title')}}</th>
                    <th data-breakpoints="lg">{{ translate('Banner') }}</th>
                    <th data-breakpoints="lg">{{ translate('Campaign') }}</th>
                    <th data-breakpoints="lg">{{ translate('Total Clicks') }}</th>
                    <th data-breakpoints="lg">{{ translate('Refer Url') }}</th>
                    <th data-breakpoints="lg">{{ translate('Start Date') }}</th>
                    <th data-breakpoints="lg">{{ translate('End Date') }}</th>
                    <th class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($affiliate_banners as $key => $affiliate_banner)
                    <tr>
                        <td>{{ ($key+1) + ($affiliate_banners->currentPage() - 1)*$affiliate_banners->perPage() }}</td>
                        <td>{{ $affiliate_banner->title }}</td>
                        <td><img src="{{ uploaded_asset($affiliate_banner->banner) }}" alt="banner" class="h-50px"></td>
                        <td>{{ $affiliate_banner->campaign }}</td>
                        <td>{{ $affiliate_banner->clicks == null ? 0 : $affiliate_banner->clicks  }}</td>
                        <td>{{ $affiliate_banner->refer_url }}</td>
                        <td>{{ date('d-m-Y H:i:s', $affiliate_banner->start_date) }}</td>
                        <td>{{ date('d-m-Y H:i:s', $affiliate_banner->end_date) }}</td>
						<td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.affiliate_banner.edit', ['id'=>$affiliate_banner->id] )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.affiliate_banner.destroy', $affiliate_banner->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="pull-right">
                {{ $affiliate_banners->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

{{--@section('script')--}}
{{--    <script type="text/javascript">--}}
{{--    </script>--}}
{{--@endsection--}}
