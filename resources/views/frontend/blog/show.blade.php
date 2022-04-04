@extends('frontend.layouts.app')

@section('meta_title'){{ $blog->meta_title }}@stop

@section('meta_description'){{ $blog->meta_description }}@stop

@section('meta_keywords'){{ $blog->meta_keywords }}@stop

@section('meta')
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $blog->meta_title }}">
<meta itemprop="description" content="{{ $blog->meta_description }}">
<meta itemprop="image" content="{{ uploaded_asset($blog->meta_img) }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ $blog->meta_title }}">
<meta name="twitter:description" content="{{ $blog->meta_description }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ uploaded_asset($blog->meta_img) }}">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $blog->meta_title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $blog->getPermalink() }}" />
<meta property="og:image" content="{{ uploaded_asset($blog->meta_img) }}" />
<meta property="og:description" content="{{ $blog->meta_description }}" />
<meta property="og:site_name" content="{{ env('APP_NAME') }}" />
@endsection

@section('content')
<div class="container space-top-2 space-bottom-2">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-6">
                    <div class="mb-4">
                        <x-tenant.system.image class="card-img rounded-2" alt="{{ $blog->title }}"
                            :image="$blog->getCover(['w'=>600]) ?? ''">
                        </x-tenant.system.image>
                    </div>
                </div>
                <div class="col-6">
                    <h1>
                        {{ $blog->title }}
                    </h1>

                    @php
                        $item = $blog;
                    @endphp

                    <ul class="list-inline list-separator font-size-1 text-body">
                        <li class="list-inline-item">
                            <i class="las la-comment text-muted mr-1"></i> 2 {{translate('Comments')}}
                        </li>
                        <li class="list-inline-item">
                            <i class="las la-calendar text-muted mr-1"></i> {{ $item->created_at->diffForHumans() }}
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Blog Content --}}

            <div class="blog-content">
                {!! $blog->content !!}
            </div>


            <div class="blog-footer">
                {{-- <x-affiliate-banner></x-affiliate-banner>--}}

                <!-- CTA Section -->

                {{-- <x-blog.news-article-subscribe></x-blog.news-article-subscribe>--}}

                @isset($blog->meta_keywords)
                <!-- Badges -->
                <div class="mt-5 d-none">
                    @foreach (explode($blog->meta_keywords, ',') as $item)
                    <a class="btn btn-xs btn-soft-secondary mb-1" href="#">{{ $item }}</a>
                    @endforeach
                </div>
                @endisset
                <!-- End Badges -->
                <!-- Share -->
                {{-- <x-blog.news-article-share></x-blog.news-article-share>--}}
                <!-- End Share -->
                {{-- <x-blog.news-article-author :blog="$blog"></x-blog.news-article-author> --}}
            </div>

            {{-- <x-default.comments.comments-list>
            </x-default.comments.comments-list> --}}
        </div>

        <!-- Author -->
        {{-- <x-blog.news-article-author :blog="$blog"></x-blog.news-article-author> --}}
        <!-- End Author -->

        {{-- TODO: Do we need an intro text before image? --}}

        {{-- <p>At Front, our mission has always been focused on bringing openness and transparency to the design
            process.
            We've always believed that by providing a space where designers can share ongoing work not only empowers
            them to make better products, it also helps them grow. We're proud to be a part of creating a more open
            culture and to continue building a product that supports this vision.</p> --}}
    </div>



    {{-- Blog Content END --}}

</div>
@endsection
