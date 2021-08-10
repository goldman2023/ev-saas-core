@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar mt-2 mb-3">
	<div class="text-md-right">
		<a href="{{ route('manual_payment_methods.create') }}" class="btn btn-circle btn-info">
			<span>{{translate('Add New Payment Method')}}</span>
		</a>
  </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Manual Payment Method')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Heading')}}</th>
                    <th>{{translate('Logo')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($manual_payment_methods as $key => $manual_payment_method)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $manual_payment_method->heading }}</td>
                        <td><img class="w-50px" src="{{ uploaded_asset($manual_payment_method->photo) }}" alt="Logo"></td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('manual_payment_methods.edit', encrypt($manual_payment_method->id))}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('manual_payment_methods.destroy', $manual_payment_method->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
