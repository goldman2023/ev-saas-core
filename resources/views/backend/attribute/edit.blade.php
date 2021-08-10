@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <a class="d-flex align-items-center mb-3" href="{{ route('admin.attributes.slug_index', ['slug' => 'sellers']) }}">
      <i class="la la-angle-left text-primary mr-1"></i>
      <h4 class="h6 mb-0">{{ translate('Back') }}</h4>
    </a>
    <h5 class="mb-0 h6">{{translate('Attribute Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
          <ul class="nav nav-tabs nav-fill border-light">
            @foreach (\App\Models\Language::all() as $key => $language)
              <li class="nav-item">
                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('admin.attributes.edit', ['id'=>$attribute->id, 'lang'=> $language->code] ) }}">
                  <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                  <span>{{ $language->name }}</span>
                </a>
              </li>
             @endforeach
          </ul>
          <form class="p-4" action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
              <input name="_method" type="hidden" value="PATCH">
              <input type="hidden" name="lang" value="{{ $lang }}">
              @csrf
              <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                  <div class="col-sm-9">
                      <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required value="{{ $attribute->getTranslation('name', $lang) }}">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Filterable')}}</label>
                  <div class="col-sm-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="hidden" name="filterable" value="off" />
                        <input type="checkbox" name="filterable" value="on" @if($attribute->filterable) checked @endif />
                        <span class="slider round"></span>
                    </label>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Admin')}}</label>
                  <div class="col-sm-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="hidden" name="is_admin" value="off" />
                        <input type="checkbox" name="is_admin" value="on" @if($attribute->is_admin) checked @endif />
                        <span class="slider round"></span>
                    </label>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Schema.org  field')}}</label>
                  <div class="col-sm-9">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="hidden" name="is_schema" value="off" />
                        <input onchange="setSchemaKey(event)" type="checkbox" name="is_schema" value="on" @if($attribute->is_schema) checked @endif />
                        <span class="slider round"></span>
                    </label>
                  </div>
              </div>
              <div class="form-group row schema-group @if(!$attribute->is_schema) d-none @endif">
									<label class="col-sm-3 col-from-label" for="schema_key">{{translate('Schema Key')}}</label>
                  <div class="col-sm-9">
                    <input type="text col-sm-9" placeholder="{{ translate('Schema Key')}}" id="schema_key" name="schema_key" class="form-control" value="{{$attribute->schema_key}}" @if($attribute->is_schema) required @endif>
                  </div>
							</div>
							<div class="form-group row schema-group @if(!$attribute->is_schema) d-none @endif">
									<label class="col-sm-3 col-from-label" for="schema_value">{{translate('Schema Value')}}</label>
                  <div class="col-sm-9">
                    <input type="text" placeholder="{{ translate('Schema Value')}}" id="schema_value" name="schema_value" class="form-control" value="{{$attribute->schema_value}}">
                  </div>
							</div>
              @if ($attribute->type == 'number')
                @php
                  $custom_properties = json_decode($attribute->custom_properties);
                @endphp
                <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Minimum Value')}}</label>
                  <div class="col-sm-9">
                    <input type="number" lang="en" min="0" step="0.01" value="{{ $custom_properties->min_value }}" placeholder="0.00" name="min_value" class="form-control @error('min_value') is-invalid @enderror" required>
                    @error('min_value')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Maximum Value')}}</label>
                  <div class="col-sm-9">
                    <input type="number" lang="en" min="0" step="0.01" value="{{ $custom_properties->max_value }}" placeholder="0.00" name="max_value" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-from-label" for="name">{{ translate('Unit')}}</label>
                  <div class="col-sm-9">
                    <input type="text" value="{{ $custom_properties->unit }}" placeholder="$, €, °, ..." name="unit" class="form-control" required>
                  </div>
                </div>
              @endif
              <div class="form-group text-right">
                  <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
              </div>
              <div class="form-group mb-3">
                @if ($attribute->type == 'dropdown' || $attribute->type == 'checkbox')
                  <div class="d-flex justify-content-between align-items-center">
                    <label>{{translate('Attribute Values')}}</label>
                    <a class="btn btn-soft-primary" href="{{route('admin.attribute_value.create', ['attribute_id'=>$attribute->id, 'lang'=>config('app.locale')] )}}">
                      {{ translate('Create New Value') }}
                    </a>
                  </div>
                  <table class="table aiz-table mb-0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>{{ translate('Name')}}</th>
                        <th class="text-right">{{ translate('Options')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($attribute->attribute_values as $key => $value)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$value->values}}</td>
                          <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.attribute_value.edit', ['id'=>$value->id, 'lang'=>config('app.locale')] )}}" title="{{ translate('Edit') }}">
                              <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.attribute_value.destroy', $value->id)}}" title="{{ translate('Delete') }}">
                              <i class="las la-trash"></i>
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif
							</div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
