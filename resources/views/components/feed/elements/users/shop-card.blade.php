@if(!empty($shop))
    <div class="w-full bg-white rounded-xl shadow {{ $class }}">
        <div class="w-full flex flex-col  justify-center items-center pb-4 relative">
            <div class="absolute top-4 right-4">
                @livewire('actions.social-action-button', [
                    'object' => $shop,
                    'action' => 'follow'
                ])
            </div>
            

            <div class="w-full flex justify-center py-4">
                <img src="{{ $shop->getThumbnail(['w' => 600]) }}" class="w-[120px] h-[120px] object-contain rounded-xl border border-gray-200"/>
            </div>
            <div class="w-full flex flex-col justify-center items-center ">
                <strong class="text-16 text-typ-1 block line-clamp-1">{{ $shop->name }}</strong>
                <span class="text-14 text-typ-3 line-clamp-1">{{ '@'.$shop->slug }}</span>
            </div>

            <div class="w-full flex justify-start items-center px-5">
                <ul class="w-full flex justify-center mb-3 border-b border-gray-200">
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <strong class="text-16 text-typ-2">{{ $shop->products()->published()->where('type', '!=', 'event')->count() }}</strong>
                        <span class="text-14 text-typ-3 block">{{ translate('Products') }}</span>
                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <strong class="text-16 text-typ-2">{{ $shop->products()->published()->where('type', '=', 'event')->count() }}</strong>
                        <span class="text-14 text-typ-3 block">{{ translate('Events') }}</span>

                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <strong class="text-16 text-typ-2">{{ $shop->blog_posts()->where('type', 'blog')->count() }}</strong>
                        <span class="text-14 text-typ-3 block">{{ translate('Articles') }}</span>

                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <strong class="text-16 text-typ-2">{{ $shop->followers()->count() }}</strong>
                        <span class="text-14 text-typ-3 block">{{ translate('Followers') }}</span>
                    </div>
                </ul>
            </div>

            <div class="w-full flex justify-center items-center gap-4 px-5 pt-1">
                <a href="{{ $shop?->getPermalink() ?? '#' }}" class="btn-primary">
                    {{ translate('Go to Shop') }}
                </a>
                <a href="#" class="btn-standard-outline">
                    {{ translate('Contact') }}
                </a>
            </div>
        </div>
    </div>
@endif