<div x-data="{
    section: @entangle('section')
}"
@display-flyout-panel.window="if($event.detail.id === id) {
    section = $event.detail.section;
}">
    
</div>