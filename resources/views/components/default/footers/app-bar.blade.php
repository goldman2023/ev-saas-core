<link href="https://bootstrap-ecommerce.com/templates/mobile/mobile-ecom-html/css/ui.css" rel="stylesheet"
    type="text/css" />
<style>
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
    <a href="/" class="nav-link active">
        @svg('heroicon-o-home', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Home') }}</span>
    </a>
    <a href="{{ route('categories.all') }}" class="nav-link text-dark">
        @svg('heroicon-o-view-grid', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Categories') }}</span>
    </a>
    <a href="{{ route('cart') }}" class="nav-link text-dark">
        @svg('heroicon-o-shopping-bag', ['style' => 'width: 24px;'])
        <span class="text text-dark">My cart</span>
    </a>
    <a href="{{ route('dashboard') }}" class="nav-link text-dark">
        @svg('heroicon-o-shopping-bag', ['style' => 'width: 24px;'])
        <span class="text text-dark">{{ translate('Profile') }}</span>
    </a>
</nav>
