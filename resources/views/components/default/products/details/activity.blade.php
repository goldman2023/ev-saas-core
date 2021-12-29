
    @php
    $activity = \Spatie\Activitylog\Models\Activity::where('subject_id', $product->id)->orderBy('created_at', 'desc')->take(5)->get();
    @endphp

    @foreach($activity as $item)
    @if($item->causer)
    <div class="card mb-3">
        <div class="card-header">
            {{ translate("By: ") }}

            {{ $item->causer->email }}
        </div>
        <div class="card-body">
            {{ $item->properties }}

        </div>
        <div class="card-footer">
            {{ $item->created_at->diffForHumans() }}
        </div>
    </div>
    @endif

    @endforeach

