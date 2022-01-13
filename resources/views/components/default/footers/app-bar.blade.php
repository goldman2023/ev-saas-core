
<style>
    .nav-bottom{
    position:fixed;
    bottom:0;
    left:0;
    width:100%;
    max-height:60px;
    z-index:12;
    background:#FFFFFF;
    -webkit-box-shadow:0 2px 7px 0 rgba(0,0,0,0.2);
    box-shadow:0 2px 7px 0 rgba(0,0,0,0.2);
    display:-webkit-box;
    display:-ms-flexbox;
    display:flex;
    -ms-flex-pack:distribute;
    justify-content:space-around
}
.nav-bottom .nav-link{
    text-align:center;
    color:#adb5bd;
    display:inline-block;
    padding:7px
}
.nav-bottom .nav-link .icon{
    display:inline-block;
    font-size:26px
}
.nav-bottom .nav-link .text{
    display:block;
    font-weight:500;
    font-size:0.8rem;
    color:#adb5bd;
    line-height: 1;
}
.nav-bottom .nav-link.active{
    color:#0d6efd
}
.nav-bottom .nav-link.active .text{
    color:#0d6efd
}
    #ev-app-bar {
        display: none;
    }

@media(max-width: 768px) {
    #ev-app-bar {
        display: flex;
    }
}
</style>
<nav class="nav-bottom text-dark" id="ev-app-bar">
    {{--  --}}
    <a href="{{ route('dashboard') }}" class="nav-link active">
        @svg('heroicon-o-home', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Home') }}</span>
    </a>
    <span x-data="" @click="$dispatch('display-wishlist')" class="nav-link text-dark">
        @svg('heroicon-o-view-grid', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Categories') }}</span>
    </span>
    <span x-data="" @click="$dispatch('display-cart')"  class="nav-link text-dark">
        @svg('heroicon-o-shopping-bag', ['style' => 'width: 24px;'])
        <span class="text text-dark">My cart</span>
    </span>
    <a href="{{ route('dashboard') }}" class="nav-link text-dark">
        @svg('heroicon-o-user-circle', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Profile') }}</span>
    </a>

    <span  @click="$dispatch('display-menu')" class="nav-link text-dark">
        @svg('heroicon-o-menu', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Menu') }}</span>
    </span>
</nav>
