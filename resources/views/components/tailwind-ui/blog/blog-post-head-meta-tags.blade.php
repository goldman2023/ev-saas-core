@props(['blogPost'])

@php
    $meta_img = $blogPost->getMetaImg(['w' => '300']);
    if(empty($blogPost->meta_image)) {
        if(empty($blogPost->thumbnail)) {
            $meta_img = $blogPost->getCover(['w' => '300']);
        } else {
            $meta_img = $blogPost->getThumbnail(['w' => '300']);
        }
    }
@endphp

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ empty($blogPost->meta_title) ? $blogPost->name : $blogPost->meta_title }}">
<meta itemprop="description" content="{{ empty($blogPost->meta_description) ? $blogPost->excerpt : $blogPost->meta_description }}">
<meta itemprop="image" content="{{ $meta_img }}">
<link rel="canonical" href="{{ $blogPost->getPermalink() }}" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="article">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ empty($blogPost->meta_title) ? $blogPost->name : $blogPost->meta_title }}">
<meta name="twitter:description" content="{{ empty($blogPost->meta_description) ? $blogPost->excerpt : $blogPost->meta_description }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ $meta_img }}">
<meta name="twitter:data1" content="{{ $blogPost->total_price }}">
<meta name="twitter:label1" content="Price">

<!-- Open Graph data -->
<meta property="og:title" content="{{ empty($blogPost->meta_title) ? $blogPost->name : $blogPost->meta_title }}" />
<meta property="og:type" content="og:article" />
<meta property="og:url" content="{{ $blogPost->getPermalink() }}" />
<meta property="og:image" content="{{ $meta_img }}" />
<meta property="og:description" content="{{ empty($blogPost->meta_description) ? $blogPost->excerpt : $blogPost->meta_description }}" />
<meta property="og:site_name" content="{{ get_tenant_setting('site_name') }}" />
