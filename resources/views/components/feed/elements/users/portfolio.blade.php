<div class="w-full bg-white rounded-xl shadow {{ $class }}">
    <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
        <h5 class="text-14 font-semibold">{{ translate('Portfolio') }}</h5>
    </div>

    <div class="px-5 pb-3 flex flex-col ">
        @if($portfolio->isNotEmpty())
            <div class="w-full grid grid-cols-12 gap-4">
                @foreach($portfolio as $index => $portfolio_item)
                    <a href="{{ $portfolio_item?->getPermalink() ?? '#' }}" class="w-full col-span-6 flex flex-col rounded-xl border border-gray-200">
                        <div class="block w-full rounded-t-xl" >
                            <img src="{{ $portfolio_item->getThumbnail(['w' => 600]) }}" class="w-full h-[120px] object-cover rounded-t-xl"/>
                        </div>
                        <div class="w-full flex flex-col p-2 h-full">
                            <strong class="text-12 text-typ-2 grow">{{ $portfolio_item->name }}</strong>

                            <div class="flex items-center justify-end text-typ-3">
                                <span class="text-12">{{ $portfolio_item->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="w-full border-t border-gray-200 flex justify-center mt-4">
                <a href="#" class="text-typ-3 hover:underline w-full pt-2 text-14 text-center">
                    {{ translate('See all') }}
                </a>
            </div>
        @else
            <div class="col-span-12 relative block w-full bg-white border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                @svg('icomoon-book', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                <span class="mt-2 block text-sm font-medium text-typ-2">{{ translate('No portfolio yet...') }}</span>

                @owner($user)
                    <a href="{{ route('blog.post.create') }}" class="btn-primary mt-3">
                        {{ translate('Add Portfolio?') }}
                    </a>
                @endowner
            </div>
        @endif
    </div>
</div>