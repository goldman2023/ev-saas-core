<style>
    .nav-bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        max-height: 60px;
        z-index: 12;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: distribute;
        justify-content: space-around
    }

    .nav-bottom .nav-link {
        text-align: center;

        padding: 7px;
    }

    .nav-bottom .nav-link .icon {
        display: inline-block;
        font-size: 26px;
        margin-bottom: 10px;
    }

    .nav-bottom .nav-link .text {
        display: block;
        font-weight: 400;
        font-size: 0.85em;
        line-height: 1.4;
        margin-top: -8px;
        margin-bottom: 5px;
    }

    .nav-bottom .nav-link.active {
        color: var(--primary-color);
    }

    .nav-bottom .nav-link.active .text {}

    #ev-app-bar {
        display: none;
    }

    @media(max-width: 768px) {
        #ev-app-bar {
            display: flex;
        }
    }

    /*
    #ev-app-bar .we-primary-mobile-button {
        background: var(--blue);
        padding: 13px;
        border-radius: 100%;
        margin-top: -20px;
    } */
</style>
<nav class="nav-bottom text-dark pt-1 !shadow-lg !bg-gray-100" id="ev-app-bar">


    {{-- TODO: Update this to use rout name --}}
    <a href="{{ route('products.all') }}" class="nav-link text-dark we-primary-mobile-button">
        @svg('heroicon-s-shopping-cart', ['class' => 'icon', 'style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('All products') }}</span>
    </a>
    @guest
    <a href="javascript:;" x-data="" @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})"
        class="nav-link text-dark">
        @svg('heroicon-s-user-circle', ['class' => 'icon', 'style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Join') }}</span>
    </a>
    @else
    <a href="/dashboard" x-data="" @click="$dispatch('display-flyout-panel', {'id': 'dashboard-sidebar-panel'})"
        class="nav-link text-dark">
        @svg('heroicon-s-user-circle', ['class' => 'icon', 'style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Dashboard') }}</span>
</a>
    @endif

    <span @click="$dispatch('display-flyout-panel', {'id' : 'categories-panel'})" class="hidden nav-link text-dark">
        @svg('heroicon-s-bars-3', ['class' => 'icon', 'style' => 'width: 24px;'])
        <span class="text">{{ translate('Menu') }}</span>
    </span>

    <a href="/kontaktai" class="nav-link text-dark">
        @svg('heroicon-s-phone', ['class' => 'icon', 'style' => 'width: 24px;'])
        <span class="text">{{ translate('Contact us') }}</span>
    </a>
</nav>
