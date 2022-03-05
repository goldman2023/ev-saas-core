<div x-data="{
    section: @entangle('section')
}"
@display-flyout-panel.window="if($event.detail.id === id) {
    {{-- TODO: Add loading spinner over whole section-edit form so we can indicate that section data is loading --}}
    setTimeout(function() {
        $wire.setSection($event.detail.section_uuid);
    }, 500);
}">
    {!! $this->custom_fields_html !!}
</div>