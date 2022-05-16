<div class="w-full">
    <div class="w-full mb-4">
        {{-- <div class="hidden sm:hidden">
            <label for="question-tabs" class="sr-only">Select a tab</label>
            <select id="question-tabs"
                class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                
                <option selected>{{ translate('Recent') }}</option>
                <option>{{ translate('Trending') }}</option>
    
                <option>{{ translate('Most Answers') }}</option>
            </select>
        </div> --}}
    
        <div class="block">
            <nav class="relative grid grid-cols-12 gap-3">
                {{-- <button wire:click="loadType('activity')"
                    class="@if($type == 'activity') text-primary @else text-gray-500 hover:text-gray-700 @endif 
                    col-span-6 sm:col-span-3 bg-white rounded-xl shadow p-3 flex items-center justify-center">
                
                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-chart-bar', ['class' => 'w-5 h-5'])
                    </div>
    
                    <span class="text-14">{{ translate('Activity') }}</span>
                </button> --}}

                <button wire:click="loadType('products')"
                    class="@if($type == 'products') text-primary @else text-gray-500 hover:text-gray-700 @endif 
                    col-span-6 sm:col-span-3 bg-white rounded-xl shadow p-3 flex items-center justify-center">
                
                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-view-grid', ['class' => 'w-5 h-5'])
                    </div>
    
                    <span class="text-14">{{ translate('Products') }}</span>
                </button>
    
                <button wire:click="loadType('articles')"
                    class="@if($type == 'articles') text-primary @else text-gray-500 hover:text-gray-700 @endif 
                    col-span-6 sm:col-span-3 bg-white rounded-xl shadow p-3 flex items-center justify-center">
                
                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-newspaper', ['class' => 'w-5 h-5'])
                    </div>
    
                    <span class="text-14">{{ translate('Articles') }}</span>
                </button>

                <button wire:click="loadType('about')"
                    class="@if($type == 'about') text-primary @else text-gray-500 hover:text-gray-700 @endif 
                    col-span-6 sm:col-span-3 bg-white rounded-xl shadow p-3 flex items-center justify-center">
                
                    <div class="rounded-full mr-2">
                        @svg('heroicon-o-user', ['class' => 'w-5 h-5'])
                    </div>
    
                    <span class="text-14">{{ translate('About') }}</span>
                </button>
            </nav>
        </div>
    </div>
    
    @if($type == 'activity')
        {{-- <div class="space-y-4 flex flex-col">
            @owner($user)
                <livewire:feed.elements.add-post />
            @endowner
            <livewire:feed.feed-list feed-type="recent" :user="$user" />
        </div> --}}
    @endif
    
    @if($type == 'about')
        <div class="flex flex-col space-y-4">
            <div class="w-full bg-white rounded-xl shadow">
                <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('About shop') }}</h5>
                </div>
            
                <div class="px-5 pb-4 ">
                    {!! $shop->content !!}
                </div>
            </div>


        </div>
    @endif

    @if($type == 'products')
        <div class="w-full grid grid-cols-12 gap-4">
            @php
                $products = $shop->products()->published()->latest()->get();
            @endphp
            @if($products->isNotEmpty())
                @foreach($products as $product)
                    <div class="col-span-12 md:col-span-6">
                        <x-tailwind-ui.products.product-card :product="$product"  />
                    </div>
                @endforeach
            @else
                <div class="col-span-12 relative block w-full bg-white border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                    @svg('icomoon-book', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                    <span class="mt-2 block text-sm font-medium text-typ-2">{{ translate('No products yet...') }}</span>

                    @shopowner($shop)
                        <a href="{{ route('blog.post.create') }}" class="btn-primary mt-3">
                            {{ translate('Add product?') }}
                        </a>
                    @endshopowner
                </div>
            @endif
        </div>
    @endif

    @if($type == 'articles')
        <div class="w-full grid grid-cols-12 gap-4">
            @php
                $blog_posts = $shop->blog_posts()->where('type', 'blog')->published()->latest()->get();
            @endphp
            @if($blog_posts->isNotEmpty())
                @foreach($blog_posts as $blog_post)
                    <div class="col-span-12 md:col-span-6">
                        <x-tailwind-ui.blog.blog-post-card :blog-post="$blog_post" />
                    </div>
                @endforeach
            @else
                <div class="col-span-12 relative block w-full bg-white border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                    @svg('icomoon-newspaper', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                    <span class="mt-2 block text-sm font-medium text-typ-2">{{ translate('No blog posts yet...') }}</span>

                    @shopowner($shop)
                        <a href="{{ route('blog.post.create') }}" class="btn-primary mt-3">
                            {{ translate('Add blog post?') }}
                        </a>
                    @endshopowner
                </div>
            @endif
        </div>
    @endif
</div>