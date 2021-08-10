<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="row">
        <div class="col">
            <h1 style="font-size: 18px;" class="pl-4 d-none d-sm-block">
                {{ $seller->user->shop->name }}

                <x-company-star-rating :company="$seller->user->shop"></x-company-star-rating>
            </h1>
        </div>
        @auth
            {{-- Check if this is a company owner --}}
            @if (auth()->user()->id === $seller->user->id)
                <div class="col text-right">
                    <a href="{{ route('shops.index') }}" class="btn btn-primary" target="_blank">
                        <i class="las la-pencil-alt"></i>
                        {{ translate('Manage Company Profile') }}</a>
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
                    href="{{ route('shop.visit', [$seller->user->shop->slug]) }}">

                    {{ translate('Overview') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'gallery' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'gallery']) }}">
                    {{ translate('Gallery') }}
                </a>


            </li>

            <li class="nav-item">
                <a class="nav-link {{ $type == 'attachments' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'attachments']) }}">
                    {{ translate('Attachments') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'news' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'news']) }}">
                    {{ translate('News') }}
                    <span class="badge badge-soft-dark rounded-circle ml-1">1</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type == 'contacts' ? 'active' : '' }}"
                    href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'contacts']) }}">
                    {{ translate('Contacts') }}
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{$type == 'subsidiary-companies' ? 'active' : ''}}" href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'subsidiary-companies']) }}">
                    {{ translate('Subsidiary companies') }}
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{$type == 'reviews' ? 'active' : ''}}" href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'reviews']) }}">
                    {{ translate('Reviews') }}
                </a>
            </li> --}}
            @if ($seller->user->products->count() > 0)
                <li class="nav-item">
                    <a class="nav-link {{$type == 'products' ? 'active' : ''}}" href="{{ route('shop.sub-page', [$seller->user->shop->slug, 'products']) }}">
                        {{ translate('Products') }}
                         <span class="badge badge-soft-dark rounded-circle ml-1">{{ $seller->user->products->count() }}</span>
                    </a>
                </li>
            @endif

            <li class="nav-item d-none">
                <a class="nav-link " href="#">
                    {{ translate('Equipment - Coming Soon') }}
                </a>
            </li>

        </ul>
    </div>
</div>
