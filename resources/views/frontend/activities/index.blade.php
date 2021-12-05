@extends('frontend.layouts.user_panel')

@section('page_title', translate('All Activity'))


@section('panel_content')
<div class="card">
    <div class="card-header">
        <h5>
        {{ translate('All activty') }}
        </h5>

        <span class="badge badge-pill badge-danger dot">

            {{ translate('Live') }}
        </span>

    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th data-breakpoints="lg">#</th>
                <th data-breakpoints="lg">{{translate('Made By')}}</th>
                <th data-breakpoints="lg">{{translate('Action Description')}}</th>
                <th data-breakpoints="lg">{{translate('Properties')}}</th>
                <th data-breakpoints="lg">{{translate('Entity Affected')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr>
                    {{--                    ID --}}
                    <td>{{$activity->id}}</td>
                    {{--                    Made By  --}}
                    <td>{{ @!class_exists($activity->causer_type) || $activity->causer == null ? "N/A" : $activity->causer->name}}</td>
                    {{--                    Action Description --}}
                    <td>{{$activity->description == null ? "N/A" : $activity->description}}</td>
                    {{--                    Properties --}}
                    <td>{{$activity->properties == null ? "N/A" : $activity->properties}}</td>
                    {{--                    Entity Affected --}}
                    <td>
                        <strong>ID: </strong>{{@!class_exists($activity->subject_type) || $activity->subject == null ? "N/A" : $activity->subject->id }}<br>
                        <strong>Type: </strong>{{@!class_exists($activity->subject_type) || $activity->subject == null ? "N/A" : $activity->subject::class }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $activities->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection
