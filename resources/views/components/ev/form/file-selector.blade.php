<div class="form-group">
    <label class="input-label" for="signinSrEmail">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    <div class="input-group" data-toggle="aizuploader" data-type="{{ $data_type }}" data-multiple="{{ $multiple }}">
        <div class="input-group-prepend">
            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
        </div>
        <div class="form-control file-amount">{{ $placeholder }}</div>
        <input type="hidden" name="{{ $name }}" class="selected-files">
    </div>
</div>

