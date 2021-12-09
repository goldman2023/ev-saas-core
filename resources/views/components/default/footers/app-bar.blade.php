<link href="https://bootstrap-ecommerce.com/templates/mobile/mobile-ecom-html/css/ui.css" rel="stylesheet" type="text/css" />

<nav class="nav-bottom">
	<a href="/" class="nav-link active">
        @svg('heroicon-o-home', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Home') }}</span>
	</a>
	<a href="{{ route('categories.all') }}" class="nav-link">
        @svg('heroicon-o-view-grid', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Categories') }}</span>
	</a>
	<a href="{{ route('cart') }}" class="nav-link">
        @svg('heroicon-o-shopping-bag', ['style' => 'width: 24px;'])
        <span class="text">My cart</span>
	</a>
	<a href="{{ route('dashboard') }}" class="nav-link">
        @svg('heroicon-o-shopping-bag', ['style' => 'width: 24px;'])
        <span class="text">{{ translate('Profile') }}</span>
	</a>
</nav>
