<div class="w-full" x-data="{
    status: @js($page->status ?? App\Enums\StatusEnum::draft()->value),
    type: @js($page->type ?? 'wysiwyg'),
    template: @js($page->template ?? ''),
    meta_img: @js(['id' => $page->meta_img->id ?? null, 'file_name' => $page->meta_img->file_name ?? '']),
    content: @entangle('page.content').defer,
}" x-init="$watch('type', () => {
    $wire.set('page.type', type);
})" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:target="savePage"
            wire:loading.class.remove="hidden"></x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none" wire:target="savePage">

            <div class="grid grid-cols-12 gap-8 mb-10">
                <div class="col-span-12 sm:col-span-12">
                    <div class="p-4 border bg-white border-gray-200 rounded-lg shadow">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Page details') }}</h3>
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Title') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.input field="page.name" />
                                </div>
                            </div>
                            <!-- END Title -->

                            @if($is_update)
                                <!-- Slug -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}">

                                    <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Slug') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-2 flex flex-col">
                                        <x-dashboard.form.input field="page.slug" class="mb-2" />
                                        <div class="text-12">
                                            {{ translate('Link').': ' }}
                                            <a href="{{ $page->getPermalink() }}" class="ml-1 text-primary"
                                                target="_blank">{{ $page->getPermalink() }}</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Slug -->
                            @endif

                            @if($page->type === \App\Enums\PageTypeEnum::wysiwyg()->value)
                                <!-- Content -->
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                    x-data="{}" wire:ignore>

                                    <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ translate('Content') }}
                                    </label>

                                    <div class="mt-1 sm:mt-0 sm:col-span-3">
                                        <x-dashboard.form.froala field="content" id="plan-content-wysiwyg">
                                        </x-dashboard.form.froala>

                                        <x-system.invalid-msg class="w-full" field="plan.content"></x-system.invalid-msg>
                                    </div>
                                </div>
                                <!-- END Content -->
                            @endif
                        </div>
                    </div>
                </div>


                {{-- Right side --}}
                <div class="col-span-12 sm:col-span-12">

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
                                <x-dashboard.form.select :items="\App\Enums\StatusEnum::toArray('archived')"
                                    selected="status" :nullable="false"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Status -->

                        <!-- Type -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Type') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="\App\Enums\PageTypeEnum::toArray()" selected="type"
                                    :nullable="false"></x-dashboard.form.select>

                                <x-system.invalid-msg field="page.type"></x-system.invalid-msg>

                            </div>
                        </div>
                        <!-- END Type -->

                        <!-- Template -->
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
                            <label class="flex items-center text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                <span class="mr-2">{{ translate('Template') }}</span>
                            </label>

                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <x-dashboard.form.select :items="$available_templates" selected="template"
                                    :nullable="true"></x-dashboard.form.select>
                            </div>
                        </div>
                        <!-- END Template -->

                        <div
                            class="w-full flex justify-between sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-5">
                            <a href="{{ route('grape.index', ['pageID' => $page->id]) }}" class="btn-info">
                                {{ translate('Open in builder') }}
                            </a>

                            @if($is_update)
                            <a href="{{ $page->getPermalink() }}" class="btn-info ml-2" target="_blank">
                                {{ translate('Preview') }}
                            </a>
                            @endif

                            <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                $wire.set('page.status', status, true);
                                $wire.set('page.type', type, true);
                                $wire.set('page.template', template, true);
                                $wire.set('page.content', content, true);
                                $wire.set('page.meta_img', meta_img.id, true);
                            " wire:click="savePage()">
                                {{ translate('Save') }}
                            </button>
                        </div>
                    </div>
                    {{-- END Actions --}}

                   <x-dashboard.global.meta-fields model-field="page" :model="$page"></x-dashboard.global.meta-fields>
                </div>
            </div>
        </div>
    </div>
</div>
