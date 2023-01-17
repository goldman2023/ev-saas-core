<div class="flex items-center font-semibold text-red-600"
    id="{{ $wef_id }}"
    @click="$dispatch('display-wef-editor-modal', {
        'target': '{{ $wef_id }}',
        'subject_id': {{ $subject->id }},
        'subject_type': '{{ base64_encode($subject::class) }}',
        'wef_key': '{{ $key }}',
        'wef_label': '{{ $label }}',
        'data_type': '{{ $type }}',
        'form_type': '{{ $form_type }}',
    })" >

    @if( $subject->getWEF($key, false, 'date'))
        {{ $subject->getWEF($key, false, 'date') }}
    @else
        {{ translate('Not set.') }}
    @endif
    @svg('heroicon-s-pencil-square', ['class' => 'ml-2 h-5 w-5 cursor-pointer'])
</div>
