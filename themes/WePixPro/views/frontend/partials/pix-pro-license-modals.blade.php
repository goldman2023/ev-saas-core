<x-system.form-modal id="pix-pro-generate-license" title="Online License Activation" class="!max-w-3xl">
    <livewire:dashboard.forms.generate-license-form />
</x-system.form-modal>

@if(auth()->user()?->isAdmin() ?? false)
    <x-system.form-modal id="pix-pro-edit-license" title="Edit License" class="!max-w-3xl">
        <livewire:dashboard.forms.licenses.license-form :user="$user" component-id="edit_license_form" />
    </x-system.form-modal>

    <x-system.form-modal id="pix-pro-create-manual-license" title="Create Manual License" class="!max-w-3xl">
        <livewire:dashboard.forms.licenses.license-form :user="$user" form-type="create" component-id="create_license_form" />
    </x-system.form-modal>
@endif