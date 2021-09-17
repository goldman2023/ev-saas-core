<div class="form-group custom-file-manager" id="file-manager-{{ $name }}" >
    @if(!empty($label))
        <label class="input-label" for="signinSrEmail">{!! $label !!} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

    <div class="input-group @error($errorBagName) is-invalid @enderror" data-toggle="aizuploader" data-type="{{ $datatype }}"
         @if($multiple) data-multiple="true" @endif
         data-is-sortable="{{ $sortable ? 'true': 'false' }}"
         data-template="{{ $template }}">

        @if($template === 'input')
            <div class="input-group-prepend">
                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
            </div>
            <div class="form-control file-amount">{{ $placeholder }}</div>
        @elseif($template === 'avatar')
            <span class="avatar avatar-circle">
                <img class="avatar-img" src="{{ $selectedFile ?: static_asset('images/photo-placeholder.jpg', false, true) }}">
            </span>
        @endif

        <input type="hidden" name="{{ $name }}" class="selected-files" wire:model="{{ $name }}" value="{{ $selectedFile }}">
    </div>

    @if($template === 'input')
        <div class="file-preview box sm @if($sortable) js-sortable @endif"
             @if(!empty($sortableOptions))
             data-hs-sortable-options='@if(is_string($sortableOptions)) {!! $sortableOptions !!} @else @json($sortableOptions) @endif'
            @endif
        >

        </div>
    @endif


    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

