<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="row">
        <div class="col">
            <h1 style="font-size: 18px;" class="pl-4 d-none d-sm-block">
                {{ $event->title }}
            </h1>
        </div>
        @auth
            {{-- Check if this is a company owner --}}
            @if (auth()->user()->id === $event->user_id)
                <div class="col text-right">
                    <a href="{{ route('seller.events') }}" class="btn btn-primary" target="_blank">
                        <i class="las la-pencil-alt"></i>
                        {{ translate('Manage Event') }}</a>
                </div>
            @endif
        @endauth
    </div>
    <div class="js-nav-scroller pl-4">
        <ul class="nav nav-tabs space-bottom-2 border-bottom-0 flex-sm-nowrap text-center" id="projectsTab"
            role="tablist">
            <li class="nav-item">
                {{-- TODO : Make active class dynamic based on sub page --}}
                <a class="nav-link {{ $type == 'overview' ? 'active' : '' }}"
                    href="{{ route('shop.visit', [$event->id]) }}">
                    {{ translate('Overview') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'gallery' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$event->id, 'gallery']) }}">
                    {{ translate('Gallery') }}
                </a>


            </li>

            <li class="nav-item">
                <a class="nav-link {{ $type == 'attachments' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$event->id, 'attachments']) }}">
                    {{ translate('Attachments') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'news' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$event->id, 'news']) }}">
                    {{ translate('News') }}
                    <span class="badge badge-soft-dark rounded-circle ml-1">1</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'contacts' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$event->id, 'contacts']) }}">
                    {{ translate('Contacts') }}
                </a>
            </li>
            @if ($event->user->products->count() > 0)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.sub-page', [$event->id, 'products']) }}">
                        {{ translate('Products') }}

                         <span class="badge badge-soft-dark rounded-circle ml-1">{{ $event->user->products->count() }}</span>
                    </a>
                </li>
            @endif

            <li class="nav-item d-none">
                <a class="nav-link " href="project-settings.html">
                    {{ translate('Equipment') }}
                </a>
            </li>

        </ul>
    </div>
</div>
