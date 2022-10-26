 {{-- SEO --}}
 <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
    open: false,
    }" :class="{'p-4': open}">
    <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
        :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('SEO') }}</h3>
        @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
    </div>

    <div class="w-full" x-show="open">

             {{-- Meta Image --}}
        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mb-5">
            <div class="flex flex-col w-full" x-data=" {}">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ translate('Meta image') }}
                </label>

                <div class="mt-1 sm:mt-0 w-full">
                    <x-dashboard.form.image-selector field="meta_img" id="page-meta-image"
                        :selected-image="$page->meta_img"></x-dashboard.form.image-selector>

                    <x-system.invalid-msg field="page.meta_img"></x-system.invalid-msg>
                </div>
            </div>
        </div>
        {{-- END Meta Image --}}
        <!-- Meta Title -->
        <div class="flex flex-col " x-data="{}">

            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ translate('Meta title') }}
            </label>

            <div class="mt-1 sm:mt-0">
                <input type="text"
                    class="form-standard @error('page.meta_title') is-invalid @enderror" {{--
                    placeholder="{{ translate('Write meta title...') }}" --}}
                    wire:model.defer="page.meta_title" />

                <x-system.invalid-msg field="page.meta_title"></x-system.invalid-msg>
            </div>
        </div>
        <!-- END Meta Title -->

        <!-- Meta Description -->
        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5" x-data="{}">

            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ translate('Meta Description') }}
            </label>

            <div class="mt-1 sm:mt-0">
                <textarea type="text"
                    class="form-standard h-[80px] @error('page.meta_description') is-invalid @enderror"
                    {{--
                    placeholder="{{ translate('Meta description which will be shown when link is shared on social network and') }}"
                    --}} wire:model.defer="page.meta_description">
            </textarea>

                <x-system.invalid-msg class="w-full" field="page.meta_description">
                </x-system.invalid-msg>
            </div>
        </div>
        <!-- END Meta Description -->





    </div>
</div>
{{-- END SEO --}}
