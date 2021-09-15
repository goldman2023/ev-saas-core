<div class="form-group custom-file-manager" id="file-manager-{{ $name }}" >
    <label class="input-label" for="signinSrEmail">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <div class="input-group @error($errorBagName) is-invalid @enderror" data-toggle="aizuploader" data-type="{{ $datatype }}"
         @if($multiple) data-multiple="true" @endif
         data-is-sortable="{{ $sortable ? 'true': 'false' }}">
        <div class="input-group-prepend">
            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
        </div>
        <div class="form-control file-amount">{{ $placeholder }}</div>
        <input type="hidden" name="{{ $name }}" class="selected-files" wire:model="{{ $name }}" value="{{ $selectedFile }}">
    </div>
    <div class="file-preview box sm @if($sortable) js-sortable @endif"
         @if(!empty($sortableOptions))
            data-hs-sortable-options='@if(is_string($sortableOptions)) {!! $sortableOptions !!} @else @json($sortableOptions) @endif'
         @endif
    >

    </div>

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

