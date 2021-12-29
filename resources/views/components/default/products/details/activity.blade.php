@php
$activity = \Spatie\Activitylog\Models\Activity::where('subject_id', $product->id)->orderBy('created_at',
'desc')->take(5)->get();
@endphp
<ul class="step step-icon-xs">
    @foreach($activity as $item)
    @if($item->causer)
    <li class="step-item">
        <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>

            <div class="step-content">
                <h5 class="mb-1">
                    <span class="text-dark" href="#">
                        Product {{ $item->properties['action'] }}
                    </span>
                </h5>

                <p class="font-size-sm mb-0">
                    <small>{{ translate('by:') }} </small>{{ $item->causer->email }} <br>
                    {{ $item->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </li>

    @endif

    @endforeach

</ul>
