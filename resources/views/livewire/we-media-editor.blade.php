<div class="we-media-editor {{ $containerClass }}" x-data="{
    displayModal: @js($displayModal),
    for_id: @entangle('for_id'),
    upload: @entangle('upload').defer,
    subject: @entangle('subject').defer,
    saveUpload() {
        $wire.saveUpload();
    },
    closeEditor() {
      this.upload = null;
      this.subject = null;
      this.displayModal = false;
    },
    reloadPreview() {
      setTimeout(function() {
        document.getElementById('we-media-editor-preview-iframe').src = document.getElementById('we-media-editor-preview-iframe').src.split('?')[0] + '?ver='+Date.now();
      }, 10);
    }
}" 
@display-media-editor-modal.window="displayModal = true;"
@reload-media-editor-preview.window="reloadPreview()"
x-show="displayModal" 
x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="{{ $wrapperClass }}" x-show="displayModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="oapcity-100"
            x-transition:leave="ease-out duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">
            &#8203;
        </span>


        <div class="max-w-[90%] lg:max-w-[1150px]  overflow-hidden overflow-y-auto relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left  shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:p-6"
            x-show="displayModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            {{-- Dismiss modal - x button --}}
            <button type="button" class="absolute top-5 right-4 z-10" @click="closeEditor()">
                @svg('heroicon-o-x-mark', ['class' => 'w-5 h-5 text-gray-500'])
            </button>

            <div class="flex flex-col max-h-[85vh]" x-data="{}">
                <!-- Modal content -->
                <div class="relative py-2 bg-white rounded-lg dark:bg-gray-800 sm:py-0">

                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 rounded-t sm:mb-5 dark:border-gray-700">
                        <h3 class="font-semibold text-2xl text-gray-900 dark:text-white" >
                            {{ $upload?->file_original_name ?? ''}}
                        </h3>
                    </div>


                    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        {{-- Upload Details --}}
                        <div class="bg-white shadow border border-gray-300 sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                              <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('File Details') }}</h3>
                              <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('All information about the upload/file can be viewed and edited here.') }}</p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                              <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ translate('File ID') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $upload?->id ?? '' }}</dd>
                                </div>

                                <div class="sm:col-span-1">
                                  <dt class="text-sm font-medium text-gray-500">{{ translate('File Name') }}</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $upload?->file_original_name ?? ''}}</dd>
                                </div>

                                <div class="col-span-1 sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">{{ translate('File URL') }}</dt>
                                    <dd class="flex flex-col mt-1 text-sm text-gray-900">
                                        @if($upload?->type === 'document')
                                          <a href="{{ $upload?->url(proxify: false) ?? '#' }}" target="_blank" class="text-sky-600 break-words">
                                              {{ $upload?->url(proxify: false) ?? '#' }}
                                          </a>
                                          <a download href="{{ $upload?->url(proxify: false) ?? '#' }}" target="_blank" class="btn-standard-outline !px-2 !py-0.5 !text-12 mr-auto mt-1" >
                                            {{ translate('Download') }}
                                          </a>
                                        @else
                                          <a href="{{ $upload?->url(proxify: true, options: ['w' => 0, 'h' => 0]) ?? '#' }}" target="_blank" class="text-sky-600 break-words">
                                              {{ $upload?->url(proxify: true, options: ['w' => 0, 'h' => 0]) ?? '#' }}
                                          </a>

                                          <a href="{{ $upload?->url(proxify: true, options: ['w' => 0, 'h' => 0]) ?? '#' }}" target="_blank" class="btn-standard-outline !px-2 !py-0.5 !text-12 mr-auto mt-1" >
                                            {{ translate('View') }}
                                          </a>
                                        @endif
                                        
                                    </dd>
                                </div>

                                <div class="sm:col-span-1">
                                  <dt class="text-sm font-medium text-gray-500">{{ translate('Type') }}</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $upload?->type ?? '' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                  <dt class="text-sm font-medium text-gray-500">{{ translate('Extension') }}</dt>
                                  <dd class="mt-1 text-sm text-gray-900">{{ $upload?->extension ?? '' }}</dd>
                                </div>

                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ translate('File size') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ formatSizeUnits($upload?->file_size ?? 0) }}</dd>
                                </div>

                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ translate('Uploaded on') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $upload?->created_at?->format('d M, Y H:i') ?? '' }}</dd>
                                </div>

                                <div class="sm:col-span-2">
                                  <dt class="text-sm font-medium text-gray-500">{{ translate('Upload Tag') }}</dt>
                                  <dd class="mt-1 text-sm text-gray-900">
                                    <livewire:dashboard.forms.wef.single-wef-form
                                      :show-form="false"
                                      :subject="$upload"
                                      wef-key="upload_tag"
                                      wef-label="{{ translate('Tag') }}"
                                      set-type="string"
                                      get-type="string"
                                      form-type="plain_text"
                                      key="{{ 'wef-tag-'.($upload?->id ?? 0).'-'.now() }}" />
                                  </dd>
                                </div>

                                {{-- <div class="sm:col-span-2">
                                  <dt class="text-sm font-medium text-gray-500">About</dt>
                                  <dd class="mt-1 text-sm text-gray-900">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>
                                </div> --}}
                              </dl>

                              {{-- Other Information (WEF & CoreMeta)--}}
                              <div class="relative py-5 mt-2">
                                  <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                  </div>
                                  <div class="relative flex justify-center">
                                    <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Other information') }}</span>
                                  </div>
                              </div>
                              <div class="grid grid-cols-1 gap-y-3">
                                @php
                                    do_action('view.dashboard.we-media-editor.other-information', $upload, $subject);
                                @endphp
                              </div>
                              {{-- END Other Information (WEF & CoreMeta) --}}


                              {{-- Custom Actions--}}
                              @php
                                  do_action('view.dashboard.we-media-editor.custom-actions', $this);
                              @endphp
                              {{-- END Custom Actions --}}
                              
                              {{-- END Other Information (WEF & CoreMeta) --}}

                            </div>
                        </div>
                        {{-- END Upload Details --}}



                          {{-- File Preview --}}
                        <div class="overflow-hidden bg-white shadow border border-gray-300 sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                              <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('File Preview') }}</h3>
                              <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('File/Document preview can be inspected here') }}</p>
                            </div>
                            <div class="border-t border-gray-200">
                                <iframe src="{{ $upload?->url() ?? '' }}" id="we-media-editor-preview-iframe" style="min-height: 60vh;" height="100%" width="100%"></iframe>
                            </div>
                        </div>
                        {{-- END File Preview --}}
                    </div>

                    {{-- WeMediaEditor Actions --}}
                    <div class="flex items-center justify-end">
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            {{-- <button type="button" class="btn-primary">
                                {{ translate('Save') }}
                            </button> --}}
                            <button type="button" class="btn-standard-outline" @click="closeEditor()">
                                {{ translate('Close') }}
                            </button>
                        </div>

                    </div>
                    {{-- END WeMediaEditor Actions --}}
                </div>
            </div>

        </div>
    </div>
</div>
