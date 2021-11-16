<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $product->meta_title }}">
<meta itemprop="description" content="{{ $product->meta_description }}">
<meta itemprop="image" content="{{ $product->getMetaImg() }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="product">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ $product->meta_title }}">
<meta name="twitter:description" content="{{ $product->meta_description }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ $product->getMetaImg() }}">
<meta name="twitter:data1" content="{{ single_price($product->unit_price) }}">
<meta name="twitter:label1" content="Price">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $product->meta_title }}" />
<meta property="og:type" content="og:product" />
<meta property="og:url" content="{{ $product->permalink }}" />
<meta property="og:image" content="{{ $product->getMetaImg() }}" />
<meta property="og:description" content="{{ $product->meta_description }}" />
<meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
<meta property="og:price:amount" content="{{ single_price($product->unit_price) }}" />
<meta property="product:price:currency"
    content="{{ \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
