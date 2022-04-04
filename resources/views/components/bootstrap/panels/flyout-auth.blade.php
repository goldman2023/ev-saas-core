<x-panels.flyout-panel id="auth-panel" title="{{ translate('Login or Register') }}">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{}">
        <span>{{ translate('Login or Register') }}</span>
    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">
        <div class="mt-3">
            <x-bootstrap.forms.login-form> </x-bootstrap.forms.login-form>
        </div>
    </div>
</x-panels.flyout-panel>
