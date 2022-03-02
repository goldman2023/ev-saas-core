<x-we-edit.flyout.flyout-panel id="we-edit-section-panel" title="{{ translate('Your Profile') }}" framework="tailwind">
    <h3 class="text-22 mb-3 pb-2 border-b flex items-center" x-data="{
        title: '',
    }" @display-flyout-panel.window="if($event.detail.id === id) {
        title = $event.detail.title;
    }">
        <span x-text="title"></span>
    </h3>

    <div class="mt-3">
        <livewire:we-edit.forms.section-edit :current_preview="$currentPreview"></livewire:we-edit.forms.section-edit>
    </div>
</x-we-edit.flyout.flyout-panel>
