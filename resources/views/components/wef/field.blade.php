<div class="flex items-center font-semibold cursor-pointer"
    id="{{ $wefId }}"
    @click="$dispatch('display-wef-editor-modal', {
        'target': '{{ $wefId }}-value',
        'subject_id': {{ $subject->id }},
        'subject_type': '{{ base64_encode($subject::class) }}',
        'wef_key': '{{ $key }}',
        'wef_label': '{{ $label }}',
        'set_type': '{{ $setType }}',
        'get_type': '{{ $getType }}',
        'form_type': '{{ $formType }}',
        'custom_properties': @js($customProperties),
    })" >

    <div id="{{ $wefId }}-value" class="">
        @if( $subject->getWEF($key, false, $getType))
            {{ $subject->getWEF($key, false, $getType) }}
        @else
            {{ translate('Not set.') }}
        @endif
    </div>
    
    @svg('heroicon-s-pencil-square', ['class' => 'ml-2 h-5 w-5 cursor-pointer'])
</div>
