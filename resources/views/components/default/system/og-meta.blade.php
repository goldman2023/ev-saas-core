<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ get_setting('meta_title') }}">
<meta itemprop="description" content="{{ get_setting('meta_description') }}">
<meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="product">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ get_setting('meta_title') }}">
<meta name="twitter:description" content="{{ get_setting('meta_description') }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

<!-- Open Graph data -->
<meta property="og:url" content="{{  url()->current() }}"/>
<meta property="og:title" content="{{ get_setting('meta_title') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ route('home') }}"/>
<meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}"/>
<meta property="og:description" content="{{ get_setting('meta_description') }}"/>
<meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
