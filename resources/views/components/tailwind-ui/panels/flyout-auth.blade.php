<x-panels.flyout-panel id="auth-panel" title="{{ translate('Welcome to ') }}">
    <h3 class="text-18 font-medium mb-3 pb-2 border-b flex items-center" x-data="{}">
        <span>{{ translate('Welcome To ') }} {{ get_site_name() }}</span>
    </h3>

    <div class="c-flyout-panel__items flex flex-col mb-1 grow">
        <div class="mt-3">
            <x-tailwind-ui.forms.login-form> </x-tailwind-ui.forms.login-form>
        </div>
    </div>
</x-panels.flyout-panel>
