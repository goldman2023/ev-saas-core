<style>
    .nav-bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        max-height: 60px;
        z-index: 12;
        background: #FFFFFF;
        -webkit-box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: distribute;
        justify-content: space-around
    }

    .nav-bottom .nav-link {
        text-align: center;
        display: flex;
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
<nav class="nav-bottom text-dark" id="ev-app-bar">
    <a href="{{ route('dashboard') }}" class="nav-link active">
        @svg('heroicon-s-home', ['style' => 'width: 24px;'])
        <span class="d-block text flex">{{ translate('Home') }}</span>
    </a>

    <span x-data="" @click="$dispatch('display-flyout-panel', {'id' : 'cart-panel'})" class="nav-link text-dark we-primary-mobile-button">
        @svg('heroicon-s-shopping-cart', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('My cart') }}</span>
    </span>
    @guest
    <a href="javascript:;"
    x-data="" @click="$dispatch('display-flyout-panel', {'id': 'auth-panel'})" class="nav-link text-dark">
        @svg('heroicon-s-user-circle', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Join') }}</span>
    </a>
    @else
    <a  x-data=""  @click="$dispatch('display-flyout-panel', {'id': 'profile-panel'})" class="nav-link text-dark">
        @svg('heroicon-s-user-circle', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Profile') }}</span>
    </a>
    @endif

    <span @click="$dispatch('display-flyout-panel', {'id' : 'categories-panel'})" class="nav-link text-dark">
        @svg('heroicon-s-menu', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Menu') }}</span>
    </span>

    <span @click="$dispatch('display-flyout-panel', {'id' : 'wishlist-panel'})" class="nav-link text-dark">
        @svg('heroicon-s-heart', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Wishlist') }}</span>
    </span>
</nav>
