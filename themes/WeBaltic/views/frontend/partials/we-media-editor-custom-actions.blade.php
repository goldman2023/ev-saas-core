<div class="relative py-5 mt-2">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
      <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
      <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Actions') }}</span>
    </div>
</div>

@if(($form->upload?->type ?? null) === 'document')
  <div class="flex flex-row justify-between">

    @if(empty($form->upload->getWEF('dokobit_signing_token')) && in_array($form->upload->getWEF('upload_tag'), \WeThemes\WeBaltic\App\Enums\DocumentUploadTagsEnum::getSignableDocumentUploadTags()))
      <button type="button" class="btn-info" @click="$wire.dynamicAction('sign_document');">
          {{ translate('Create Signing Form') }}
      </button>
    @endif

    <button type="button" class="btn-primary" @click="$wire.dynamicAction('regenerate_document');">
        {{ translate('Regenerate') }}
    </button>
  </div>

  {{--  --}}
  @if(!empty($form->upload->getWEF('dokobit_signing_token')) && !empty($form->upload->getWEF('dokobit_signer_1_token')) && !empty($form->upload->getWEF('dokobit_signer_2_token')))
    <div class="relative py-5 mt-2">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
          <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center">
          <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Signing Info & Actions') }}</span>
        </div>
    </div>

    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">

      <div class="sm:col-span-2">
        <dt class="text-sm font-medium text-gray-500">{{ translate('Agent signing token') }}</dt>
        <dd class="mt-1 text-sm text-gray-900">{{ $form->upload->getWEF('dokobit_signer_2_token') }}</dd>
      </div>

      <div class="sm:col-span-2">
        <dt class="text-sm font-medium text-gray-500">{{ translate('Agent signing URL') }}</dt>
        <a class="mt-1 text-sm text-sky-600" href="{{ $form->upload->getWEF('dokobit_signer_2_signing_form_url') }}" target="_blank">
          {{ $form->upload->getWEF('dokobit_signer_2_signing_form_url') }}
        </a>
      </div>

      <div class="sm:col-span-2">
          <dt class="text-sm font-medium text-gray-500">{{ translate('Customer signing token') }}</dt>
          <dd class="mt-1 text-sm text-gray-900">{{ $form->upload->getWEF('dokobit_signer_1_token') }}</dd>
      </div>

      <div class="sm:col-span-2">
        <dt class="text-sm font-medium text-gray-500">{{ translate('Customer signing URL') }}</dt>
        <a class="mt-1 text-sm text-sky-600" href="{{ $form->upload->getWEF('dokobit_signer_1_signing_form_url') }}" target="_blank">
          {{ $form->upload->getWEF('dokobit_signer_1_signing_form_url') }}
        </a>
      </div>
    </dl>
  @endif
  
@endif
