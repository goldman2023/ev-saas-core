@extends('frontend.layouts.feed')

@section('meta_title'){{ $blog_post->name.' | '.get_site_name() }}@endsection

@section('meta')
    <x-tailwind-ui.blog.blog-post-head-meta-tags :blog-post="$blog_post"></x-tailwind-ui.blog.blog-post-head-meta-tags>
@endsection

@section('feed_content')
<div class="col-span-12">
    <section class="grid grid-cols-12 gap-6 max-w-2xl md:max-w-full mx-auto">
        <div class="bg-white col-span-12 md:col-span-8 flex flex-col space-y-4 border border-gray-200 rounded-xl overflow-x-hidden">
            {{-- Cover --}}
            <div class="w-full mb-3">
                <x-tenant.system.image class="block max-h-[300px] sm:max-h-[300px] md:max-h-[340px] h-full w-full rounded-t-xl " fit="cover" :image="empty($blog_post->cover) ? $blog_post->getThumbnail(['w' => '900']) : $blog_post->getCover(['w' => 1200])" />
            </div>
            <div class="w-full flex items-center px-5 pb-5">
                <x-tenant.system.image alt="{{ get_site_name() }} logo"
                    class="ring-2 ring-indigo-400 bg-white h-[50px] w-[50px] rounded-full mr-3" fit="contain"
                    :image="$shop->getThumbnail()">
                </x-tenant.system.image>

                {{-- Authors --}}
                <div class="flex flex-col">
                    <h3 class="flex items-center mb-0 text-18 font-bold text-typ-1">
                        @foreach($authors as $index => $author)
                            <a href="{{ $author->getPermalink() }}" class="text-14 font-bold text-typ-1">
                                {{ $author->name.' '.$author->surname.($index+1 == $authors->count() ? '':',') }}
                            </a>
                        @endforeach
                        <span class="mx-1 text-typ-3 text-14 font-medium">{{ translate('for') }}</span>
                        <a href="{{ $shop->getPermalink() }}" class="text-typ-1 text-14">
                            {{ $shop->name }}
                        </a>
                    </h3>
                    <div class="flex items-center text-sm font-medium text-typ-3 text-12">
                        {{ translate('Posted on').' '.$blog_post->created_at->format('d M, Y') }}
                    </div>
                </div>
            </div>

            {{-- Title & Content--}}
            <div class="flex flex-col px-6 sm:px-8">
                <h1 class="w-full text-18 sm:text-22 text-typ-1 mb-5 text-center font-semibold">
                    {{ $blog_post->name }}
                </h1>
                <div class="w-full wysiwyg_content">
                    {!! $blog_post->content !!}
                </div>
                @if($blog_post->type === 'portfolio' && !empty($blog_post->getCoreMeta('portfolio_link')) )
                    <div class="w-full flex justify-center mt-5">
                        <a href="{{ $blog_post->getCoreMeta('portfolio_link') }}" class="btn-primary" target="_blank">
                            {{ translate('Check portfolio') }}
                        </a>
                    </div>
                @endif
            </div>

            {{-- Comments --}}
            <div class="flex flex-col px-5 py-4 mt-4 border-t border-gray-200">
                <h3 class="text-lg font-bold mb-3">
                    {{ translate('Discussion') }} ({{ $blog_post->comments->count() }})
                </h3>

                <livewire:actions.social-comments :item="$blog_post">
                </livewire:actions.social-comments>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-span-12 md:col-span-4">
            @if(!empty($shop))
                <x-feed.elements.users.shop-card :shop="$shop" class="mb-5" />
            @endif

            @if($related_blog_posts->isNotEmpty())
            {{-- Recent --}}
            <div class="w-full bg-white rounded-xl shadow">
                <div class="w-full px-5 py-4 mb-5 flex justify-between border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('Related Posts') }}</h5>
                </div>
            
                <div class="px-5 pb-4 flex flex-col">
                    @foreach($related_blog_posts as $blog_post)
                        <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" template="row" />
                    @endforeach
                </div>

                <div class="w-full border-t border-gray-200 flex justify-center">
                    <a href="#" class="text-typ-3 hover:underline w-full py-2 text-14 text-center">
                        {{ translate('See all') }}
                    </a>
                </div>
            </div>
            @endif

            
        </div>
    </section>
</div>
@endsection
