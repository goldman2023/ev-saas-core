<div class="w-full flex flex-col" x-data="{
    theme: @js($theme),
    currentTheme: @js($currentTheme),
}">
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
</div>
