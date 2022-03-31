<div class="w-full max-w-[770px] grid grid-cols-10 gap-8" x-data="{
        current: @js(!empty($thumbnail) ? $thumbnail : $cover),
    }">
    {{-- @dd($model->getThumbnail(['w'=>600]))
    @dd($model->getGallery(['w' => 700, 'h' => 0])) --}}

    @if(!empty($gallery))
        <div class="col-span-2 ">
            <div class="max-h-[480px] overflow-hidden">
                <div class="w-full mb-5 aspect-[1/1] border border-gray-200 shadow cursor-pointer" @click="current = @js(!empty($thumbnail) ? $thumbnail : $cover)">
                    <img class="w-full aspect-[1/1] object-cover" src="{{ !empty($thumbnail) ? $thumbnail : $cover }}" />
                </div>

                @foreach($gallery as $index => $src)
                    <div class="w-full mb-5 aspect-[1/1] border border-gray-200 shadow cursor-pointer" @click="current = @js($src)">
                        <img class="w-full aspect-[1/1] object-cover" src="{{ $src }}" />
                    </div>
                @endforeach
            </div>
            
            <div class="w-full grid grid-cols-2 gap-2 mt-4">
                <button type="button" class="btn-primary">@svg('heroicon-o-chevron-up', ['class' => ''])</button>
                <button type="button" class="btn-primary">@svg('heroicon-o-chevron-down', ['class' => ''])</button>
            </div>
        </div>
    @endif
    <div class="col-span-{{ !empty($gallery) ? '8':'10' }}">
        <img class="w-full h-full object-contain" :src="current" alt="" />
    </div>
{{-- 
    <x-tenant.system.image class="object-center object-cover w-full"
        :image="$product->getThumbnail(['w'=>600]) ?? ''">
    </x-tenant.system.image>

    <div class="row">
        @foreach($product->getGallery(['h' => 600]) as $item)
        <div class="col-4 mb-3">
            <x-tenant.system.image class="object-center object-cover" fit="cover" :image="$item ?? ''">
            </x-tenant.system.image>
        </div>
        @endforeach
    </div> --}}

</div>