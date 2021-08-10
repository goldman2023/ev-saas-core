@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Events')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('admin.events.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New Events')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <form class="" id="sort_events" action="" method="GET">
      <div class="card-header row gutters-5">
        <div class="col text-center text-md-left">
          <h5 class="mb-md-0 h6">{{ translate('Events') }}</h5>
        </div>
          <div class="col-md-3">
            <div class="form-group mb-0">
              <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name or email & Enter') }}">
            </div>
          </div>
      </div>
    </from>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th data-breakpoints="lg">#</th>
                <th>{{translate('Title')}}</th>
                <th data-breakpoints="lg">{{translate('Description')}}</th>
                <th data-breakpoints="lg">{{translate('Image')}}</th>
                <th width="10%">{{translate('Options')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $key => $event)
                @if($event->user != null )
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$event->title}}</td>
                        <td>{{$event->description}}</td>
                        <td><span><img style="width:50px;" src="{{URL::asset($event->upload->file_name)}}" alt="" srcset=""></span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                  <i class="las la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    <a href="{{route('event.show', $event->slug)}}" class="dropdown-item" target="_blank">
                                      {{translate('Detail View')}}
                                    </a>
                                    <a href="{{route('admin.events.edit', $event->id)}}" class="dropdown-item" data-test="editItem">
                                      {{translate('Edit')}}
                                    </a>
                                    <a href="#" class="dropdown-item confirm-delete" data-href="{{route('admin.events.destroy', $event->id)}}" data-test="deleteItem">
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
          {{ $events->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
	<!-- Delete Modal -->
	@include('modals.delete_modal')
@endsection

