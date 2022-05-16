<div class="w-full" x-data="{
    status: @js($page->status ?? App\Enums\StatusEnum::draft()->value),
    type: @js($page->type ?? 'wysiwyg'),
    meta_img: @js(['id' => $page->meta_img->id ?? null, 'file_name' => $page->meta_img->file_name ?? '']),
    content: @entangle('page.content').defer,
}" x-init="$watch('type', () => {
    $wire.set('page.type', type);
})"
     @validation-errors.window="$scrollToErrors($event.detail.errors, 700);"
     x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden"
                              wire:target="savePage"
                              wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full"
             wire:loading.class="opacity-30 pointer-events-none"
             wire:target="savePage"
        >

        <div class="grid grid-cols-12 gap-8 mb-10">
            <div class="col-span-12 xl:col-span-8">
                <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Page details') }}</h3>
                    </div>
            
                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                        <!-- Title -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
            
                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                {{ translate('Title') }}
                            </label>
            
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.input field="page.name" />
                            </div>
                        </div>
                        <!-- END Title -->

                        @if($page->type === \App\Enums\PageTypeEnum::wysiwyg()->value)
                            <!-- Content -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}" wire:ignore>
                
                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Content') }}
                                </label>
                
                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.froala field="content" id="plan-content-wysiwyg"></x-dashboard.form.froala>
                                
                                    <x-system.invalid-msg class="w-full" field="plan.content"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Content -->
                        @endif
                    </div>
                </div>
            </div>


            {{-- Right side --}}
            <div class="col-span-12 xl:col-span-4">

                {{-- Actions --}}
                <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                    <!-- Status -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            <span class="mr-2">{{ translate('Status') }}</span>

                            @if($page->status === App\Enums\StatusEnum::published()->value)
                                <span class="badge-success">{{ ucfirst($page->status) }}</span>
                            @elseif($page->status === App\Enums\StatusEnum::draft()->value)
                                <span class="badge-warning">{{ ucfirst($page->status) }}</span>
                            @elseif($page->status === App\Enums\StatusEnum::pending()->value)
                                <span class="badge-info">{{ ucfirst($page->status) }}</span>
                            @elseif($page->status === App\Enums\StatusEnum::private()->value)
                                <span class="badge-dark">{{ ucfirst($page->status) }}</span>
                            @endif
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')" selected="status" :nullable="false"></x-dashboard.form.select>
                        </div>
                    </div>
                    <!-- END Status -->

                    <!-- Type -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                        <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            <span class="mr-2">{{ translate('Type') }}</span>
                        </label>

                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-dashboard.form.select :items="\App\Enums\PageTypeEnum::toArray()" selected="type" :nullable="false"></x-dashboard.form.select>
                        </div>
                    </div>
                    <!-- END Type -->

                    <div class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                        <a href="{{ route('grape.index', ['pageID' => $page->id]) }}" class="btn-info">
                            {{ translate('Open in builder') }}
                        </a>

                        @if($is_update)
                            <a href="{{ $page->getPermalink() }}" class="btn-info ml-2" target="_blank">
                                {{ translate('Preview') }}
                            </a>
                        @endif

                        <button type="button" class="btn btn-primary ml-auto btn-sm"
                            @click="
                                $wire.set('page.status', status, true);
                                $wire.set('page.type', type, true);
                                $wire.set('page.content', content, true);
                                {{-- $wire.set('page.meta_img', meta_img.id, true); --}}
                            "
                            wire:click="savePage()">
                        {{ translate('Save') }}
                        </button>
                    </div>
                </div>
                {{-- END Actions --}}

                {{-- SEO --}}
                <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
                    open: false,
                }" :class="{'p-4': open}">
                    <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open" :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('SEO') }}</h3>
                        @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
                    </div>
            
                    <div class="w-full" x-show="open">
                        <!-- Meta Title -->
                        <div class="flex flex-col " x-data="{}">
                                    
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ translate('Meta title') }}
                            </label>

                            <div class="mt-1 sm:mt-0">
                                <x-dashboard.form.input field="page.meta_title" />
                            </div>
                        </div>
                        <!-- END Meta Title -->

                        {{-- Meta Image --}}
                        <div class="flex flex-col sm:border-t sm:border-gray-200 sm:pt-4 sm:mt-5">
                            <div class=s"flex flex-col " x-data="{}">
                                        
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ translate('Meta image') }}
                                </label>

                                <div class="mt-1 sm:mt-0">
                                    <x-dashboard.form.image-selector field="meta_img" id="page-meta-image" :selected-image="$page->meta_img"></x-dashboard.form.image-selector>
                                    
                                    <x-system.invalid-msg field="page.meta_img"></x-system.invalid-msg>
                                </div>
                            </div>
                        </div>
                        {{-- END Meta Image --}}
                        
                    </div>
                </div>
                {{-- END SEO --}}

                
            </div>
        
        </div>
    </div>
</div>
