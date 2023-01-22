<div class="relative py-5 mt-2">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
      <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
      <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Actions') }}</span>
    </div>
</div>

@if(($form->upload?->type ?? null) === 'document')
  <div class="flex flex-row justify-end">
    <button type="button" class="btn-primary" @click="$wire.dynamicAction('regenerate_document');">
        {{ translate('Regenerate') }}
    </button>
  </div>
@endif
