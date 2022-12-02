<!-- Main modal -->
<div id="order-document-modal-{{ $document['id'] }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-5xl p-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 rounded-t sm:mb-5 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    {{ $document['title'] }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="order-document-modal-{{ $document['id'] }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <dl class="p-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <dt class="sr-only">Date</dt>
                    <dd class="flex items-center mb-2 font-light text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400 dark:text-gray-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-gray-900 dark:text-white">
                            26th November, 2022</span>
                    </dd>
                    <dt class="sr-only">Location</dt>
                    <dd class="flex items-center mb-4 font-light text-gray-500 dark:text-gray-400 sm:mb-5">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400 dark:text-gray-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium text-gray-900 dark:text-white">California, USA</span>
                    </dd>

                    <x-dashboard.forms.core-meta-field :subject="$document" field="notes"></x-dashboard.forms.core-meta-field>

                    <x-dashboard.forms.core-meta-field field="assembler"></x-dashboard.forms.core-meta-field>


                    <dt class="mb-2 leading-none text-gray-500 dark:text-gray-400">
                        {{ translate('Notes') }}
                    </dt>
                    <dd class="mb-4 font-medium text-gray-900 sm:mb-5 dark:text-white">
                        Add a note
                    </dd>
                    <dt class="mb-2 leading-none text-gray-500 dark:text-gray-400">Duration</dt>
                    <dd class="font-medium text-gray-900 dark:text-white">All day </dd>
                    <div class="mt-6 grid grid-cols-2 gap-6">
                        <div>
                            <button type="button"
                                class="w-full inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                @svg('heroicon-o-clipboard-document-check', ['class' => 'w-5 h-5 mr-1.5 -ml-1'])

                                {{ translate('Sign') }}
                            </button>
                        </div>

                        <div>
                            <button type="button"
                                class="w-full inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                @svg('heroicon-o-document-arrow-down', ['class' => 'w-5 h-5 mr-1.5 -ml-1'])

                                {{ translate('Download') }}
                            </button>
                        </div>
                        <div>
                        </div>
                    </div>
                </dl>
                <dl>
                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">
                        {{ translate('Document preview') }}
                    </dt>
                    <dd class="font-light text-gray-500 dark:text-gray-400">
                        <iframe src="{{ $document['url'] }}" style="min-height: 60vh;"
                            title="testPdf" height="100%" width="100%"></iframe>

                    </dd>
                </dl>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <button type="button"
                        class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Edit
                    </button>
                    <button type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Preview
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
