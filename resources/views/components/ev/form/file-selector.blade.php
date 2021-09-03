<div class="form-group">
    <label class="input-label" for="signinSrEmail">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <div class="input-group" data-toggle="aizuploader" data-type="{{ $datatype }}" @if($multiple) data-multiple="true" @endif >
        <div class="input-group-prepend">
            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
        </div>
        <div class="form-control file-amount">{{ $placeholder }}</div>
        <input type="hidden" name="{{ $name }}" class="selected-files" wire:model="{{ $name }}">
    </div>
    <div class="file-preview box sm">

    </div>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

