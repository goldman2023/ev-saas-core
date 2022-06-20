<div x-data="{
    license: @entangle('license').defer,
    license_data: @entangle('license_data').defer,
}" wire:loading.class="opacity-30 pointer-events-none" @display-modal.window="
    if($event.detail.id === id) {
        $wire.setLicense($event.detail.license_id);
    }
">
@if($license)
    @foreach($license->audits as $audit)
    This is audit
    {{ json_encode($audit)}}
    @endforeach
    @endif
</div>
