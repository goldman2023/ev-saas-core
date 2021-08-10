@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th data-breakpoints="lg">{{translate('Attribute Action')}}</th>
                <th data-breakpoints="lg">{{translate('Attribute Info')}}</th>
                <th data-breakpoints="lg">{{translate('Datetime')}}</th>
            </tr>
            </thead>
            <tbody>
            @if(!is_null($shop_audits))
                @foreach($shop_audits as $audit)
                    <tr>
                        @foreach($audit->getModified() as $key=>$arr_value)

                            @switch($key)
                                @case('attribute_id')
                                <td>{{translate('Attribute Changed')}}</td>
                                <td>
                                    @foreach($arr_value as $status=>$value)

                                        @if($status == 'new')
                                            <strong>New Value = {{\App\Models\Attribute::find($value)->name}}</strong> <br>
                                        @elseif($status == 'old')
                                            <strong>Old Value = {{\App\Models\Attribute::find($value)->name}}</strong>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{\Carbon\Carbon::parse($audit->created_at)->format('d-M-Y H:i')}}</td>
                    </tr>
                    @break
                    @case('attribute_value_id')
                    <td>{{\App\Models\Attribute::find(\App\Models\AttributeValue::find($arr_value['new'])->attribute_id)->name. translate(' Value Changed')}}</td>
                    <td>
                        @foreach($arr_value as $status=>$value)

                            @if($status == 'new')
                                <strong>New Value = {{\App\Models\AttributeValue::find($value)->values}}</strong> <br>

                            @elseif($status == 'old')
                                <strong>Old Value = {{\App\Models\AttributeValue::find($value)->values}}</strong>
                            @endif
                        @endforeach
                    </td>
                    <td>{{\Carbon\Carbon::parse($audit->created_at)->format('d-M-Y H:i')}}</td>
                    </tr>
                    @break
                    @endswitch

                @endforeach
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $shop_audits->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
