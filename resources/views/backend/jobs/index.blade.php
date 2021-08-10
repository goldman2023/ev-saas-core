@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Jobs')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('admin.jobs.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New Job')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <form class="" id="sort_events" action="" method="GET">
      <div class="card-header row gutters-5">
        <div class="col text-center text-md-left">
          <h5 class="mb-md-0 h6">{{ translate('Jobs') }}</h5>
        </div>
          <div class="col-md-3">
            <div class="form-group mb-0">
              <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name or content & Enter') }}">
            </div>
          </div>
      </div>
    </form>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th data-breakpoints="lg">#</th>
                <th>{{translate('Title')}}</th>
                <th data-breakpoints="lg">{{translate('excerpt')}}</th>
                <th data-breakpoints="lg">{{translate('content')}}</th>
                <th width="10%">{{translate('Options')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jobs as $key => $item)
                @if($item->shop != null )
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->excerpt}}</td>
                        <td>{{$item->content}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                  <i class="las la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    <a href="{{route('admin.jobs.visit', ['shop_slug' => auth()->user()->shop->slug, 'job_slug' => $item->slug] )}}" class="dropdown-item">
                                      {{translate('Detail View')}}
                                    </a>
                                    <a href="{{route('admin.jobs.edit', $item->id)}}" class="dropdown-item">
                                      {{translate('Edit')}}
                                    </a>
                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{route('admin.jobs.destroy', $item->id)}}" class="">
                                      {{translate('Delete')}}
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
          {{ $jobs->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
	<!-- Delete Modal -->
	@include('modals.delete_modal')
@endsection

