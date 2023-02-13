<div class="w-full flex flex-col" x-data="{
    theme: @js($theme),
    currentTheme: @js($currentTheme),
    currentThemeTailwindConfig: @entangle('currentThemeTailwindConfig').defer,
}">
@push('head_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.0/jsoneditor.min.js" integrity="sha512-WuimD+3eJ3qkskeMQiQZesaYjwyBiTN2Xg2tI60IDp5jx402/u8lLZAqCgAei92NInz0Jn+xYqJKYCbxic4hIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.9.0/jsoneditor.min.css" integrity="sha512-8ca3Rhl1VGRZ72Vjj35LcQasrUEZZLknd2qJF/RDQocmA/4q/v5gD3H7NZtZ2ssfkN6VqDuzKqYdeaT0YUubZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
    <div class="w-full flex flex-wrap">
        <x-dashboard.form.select field="theme" :items="$themes" selected="theme" :nullable="false" :hide-error="true" selector-class="min-w-[200px] lg:min-w-[250px]"></x-dashboard.form.select>
        
        <button type="button" class="btn btn-primary ml-3 btn-sm"
            @click="
                $wire.set('theme', theme, true);
            "
            wire:click="saveTheme()">
            {{ translate('Save') }}
        </button>

        
    </div>
    <p class="w-full mt-2">{{ translate('Current theme for domain') }}<span class="underline mx-1 italic">({{ $domain->domain }})</span> is <span class="badge-info">{{ $currentTheme }}</span></p>
    <x-system.invalid-msg field="theme"></x-system.invalid-msg>

    <div class="w-full flex flex-col mt-2">
        <x-dashboard.form.json-editor field="currentThemeTailwindConfig" id="theme-tailwind-config-json-editor" />

        <button type="button" class="btn btn-primary ml-auto btn-sm mt-2"
            @click="
                $wire.set('currentThemeTailwindConfig', currentThemeTailwindConfig, true);
            "
            wire:click="saveTailwindConfig()">
            {{ translate('Save') }}
        </button>
    </div>
</div>
