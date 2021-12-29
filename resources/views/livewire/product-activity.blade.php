<ul class="step step-icon-xs" wire:poll.5s>
    @foreach($activity as $item)
    @if($item->causer)
    <li class="step-item">
        <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-dark step-icon-pseudo"></span>

            <div class="step-content">
                <h5 class="mb-1">
                    <span class="text-dark" href="#">
                        @isset($item->properties['action'])
                        Product {{ $item->properties['action'] }}
                        @else
                        Product {{ $item->description }}
                        @endisset
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


