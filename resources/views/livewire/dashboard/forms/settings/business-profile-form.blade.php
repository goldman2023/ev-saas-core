@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

<div class="w-full" x-data="{
        current: 'basicInformation',
        content: @entangle('settings.content').defer,
        settings: @js($settings),
    }" x-init="$watch('current', function(value) {
        window.scroll({
            behavior: 'smooth',
            left: 0,
            top: document.getElementById(value).offsetTop
        });
    })" 
    @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" 
    @submit-form.window="
        $wire.set('settings.thumbnail', thumbnail.id, true);
        $wire.set('settings.cover', cover.id, true);
        $wire.set('settings.websites', settings.websites, true);
        $wire.set('settings.phones', settings.phones, true);
        $wire.set('settings.content', content, true);
        $wire.saveBasicInformation();
    "
    x-cloak>

    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden">
        </x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">

            <div class="grid grid-cols-12 gap-8 mb-10">
                <div class="col-span-12 lg:col-span-3">
                    <nav class="space-y-1 p-4 bg-white rounded-lg border border-gray-200">
                        <a href="#"
                            :class="{'text-primary': current === 'basicInformation', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'basicInformation'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'basicInformation'">

                            @svg('heroicon-o-user', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Basic information') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'companyInfoSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'companyInfoSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'companyInfoSection'">

                            @svg('heroicon-o-office-building', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Company information') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'contactDetails', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'contactDetails'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'contactDetails'">

                            @svg('heroicon-o-phone', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Contact details') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'addressesSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'addressesSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'addressesSection'">

                            @svg('heroicon-o-location-marker', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Addresses') }}</span>
                        </a>

                    </nav>

                </div>
