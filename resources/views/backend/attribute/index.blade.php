@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
		<h1 class="h3">{{translate('All Attributes')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Attributes')}}</h5>
			</div>
			<div class="card-body">
				<table class="table aiz-table mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ translate('Name')}}</th>
							<th>{{ translate('Type')}}</th>
							<th class="text-right">{{ translate('Options')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($attributes as $key => $attribute)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$attribute->getTranslation('name')}}</td>
								<td>{{$attribute->type}}</td>
								<td class="text-right">
									<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.attributes.edit', ['id'=>$attribute->id, 'lang'=>config('app.locale')] )}}" title="{{ translate('Edit') }}">
										<i class="las la-edit"></i>
									</a>
									<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.attributes.destroy', $attribute->id)}}" title="{{ translate('Delete') }}">
										<i class="las la-trash"></i>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
					<h5 class="mb-0 h6">{{ translate('Add New Attribute') }}</h5>
			</div>
			<div class="card-body">
					<form action="{{ route('admin.attributes.store') }}" method="POST">
							@csrf
							<div class="form-group mb-3">
									<label for="name">{{translate('Name')}}</label>
									<input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" data-test="name" required>
							</div>
							<div class="form-group mb-3 d-none schema-group">
									<label for="name">{{translate('Schema Key')}}</label>
									<input type="text" placeholder="{{ translate('Schema Key')}}" id="schema_key" name="schema_key" class="form-control">
							</div>
							<div class="form-group mb-3 d-none schema-group">
									<label for="name">{{translate('Schema Value')}}</label>
									<input type="text" placeholder="{{ translate('Schema Value')}}" id="schema_value" name="schema_value" class="form-control">
							</div>
							<div class="form-group mb-3">
								<label for="choice_attributes">{{translate('Type')}}</label>
								<select onchange="onChangeType(this)" name="type" id="choice_attributes" class="form-control aiz-selectpicker" data-selected-text-format="count" data-live-search="true" data-placeholder="{{ translate('Choose Attributes') }}" data-test="select-attr">
									<option value="dropdown" selected>{{ translate('DropDown') }}</option>
									<option value="date">{{ translate('Date') }}</option>
									<option value="plain_text">{{ translate('Plain Text') }}</option>
									<option value="checkbox">{{ translate('CheckBox') }}</option>
									<option value="country">{{ translate('Country') }}</option>
									<option value="number">{{ translate('Number') }}</option>
									<option value="date">{{ translate('Date') }}</option>
								</select>
							</div>

							<div class="form-group mb-3">
								<label class="aiz-checkbox">
									<input type="checkbox" name="filterable" id="filterable">
									<span>{{ translate('Filterable') }}</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>

							<div class="form-group mb-3">
								<label class="aiz-checkbox">
									<input type="checkbox" name="is_admin" id="is_admin">
									<span>{{ translate('Admin') }}</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>

							<div class="form-group mb-3">
								<label class="aiz-checkbox">
									<input onchange="setSchemaKey(event)" type="checkbox" name="is_schema" id="is_schema">
									<span>{{ translate('Schema.org  field') }}</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>

							<input type="hidden" name="content_type" value="{{$content_type}}" />
							<input type="hidden" name="slug" value="{{$slug}}" />
							<div class="form-group mb-3 text-right">
								<button type="submit" class="btn btn-primary" data-test="submit">{{translate('Save')}}</button>
							</div>
					</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function onChangeType(evt){
			$("#filterable").prop("checked", false);
			if (evt.value == "plain_text") {
				$("#filterable").attr("disabled", true);
			} else {
				$("#filterable").removeAttr("disabled");
			}
        }
    </script>
@endsection
