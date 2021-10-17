@extends('frontend.layouts.feed')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-8">
                @foreach ($activities as $activity)

                    <div class="card mb-3" id="activity_card_uid_{{ $activity->id }}">
                        <div class="card-header d-block">
                            <div class="row">
                                <div class="col-1">
                                    Avatar
                                </div>

                                <div class="col-8">
                                    <div class="font-weight-bold">
                                        {{ @!class_exists($activity->causer_type) || $activity->causer == null ? 'N/A' : $activity->causer->name }}

                                    </div>

                                    <div class="">
                                        {{ $activity->description == null ? 'N/A' : $activity->description }}
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-body">
                            {{-- ID --}}
                            <td></td>
                            {{-- Made By --}}
                            </td>
                            {{-- Action Description --}}
                            <td></td>
                            {{-- Properties --}}
                            <td>{{ $activity->properties == null ? 'N/A' : $activity->properties }}</td>
                            {{-- Entity Affected --}}
                            <td>
                                <strong>ID:
                                </strong>{{ @!class_exists($activity->subject_type) || $activity->subject == null ? 'N/A' : $activity->subject->id }}<br>
                                <strong>Type:
                                </strong>{{ @!class_exists($activity->subject_type) || $activity->subject == null ? 'N/A' : get_class($activity->subject) }}
                            </td>

                        </div>

                    </div>
                @endforeach
            </div>

            <div class="col-md-2">

            </div>
        </div>
    </div>
@endsection
