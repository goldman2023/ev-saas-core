<div class="flex items-center font-semibold"
    id="{{ $wefId }}"
    @click="$dispatch('display-wef-editor-modal', {
        'target': '{{ $wefId }}',
        'subject_id': {{ $subject->id }},
        'subject_type': '{{ base64_encode($subject::class) }}',
        'wef_key': '{{ $key }}',
        'wef_label': '{{ $label }}',
        'data_type': '{{ $type }}',
        'form_type': '{{ $form_type }}',
        'custom_properties': {'range': false, 'with_time': false},
    })" >

    @if( $subject->getWEF($key, false, $type))
        {{ $subject->getWEF($key, false, $type) }}
    @else
        {{ translate('Not set.') }}
    @endif
    @svg('heroicon-s-pencil-square', ['class' => 'ml-2 h-5 w-5 cursor-pointer'])
</div>
