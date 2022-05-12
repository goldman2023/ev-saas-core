<div class="bg-white p-4 sm:p-5 rounded-md shadow" x-data="{
    isModalOpen: false,
    thumbnail: @js(['id' => $post->thumbnail->id ?? null, 'file_name' => $post->thumbnail->file_name ?? '']),
}"
x-on:reset-image-selector.window="thumbnail = @js(['id' => null, 'file_name' => ''])"
x-on:keydown.escape="isModalOpen=false">
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <div class="flex-shrink-0 ">
                <img class="h-11 w-11 rounded-full border-3 ring-2 ring-gray-200 object-cover"
                    src="{{ auth()->user()->getThumbnail() }}"
                    alt="feed-avatar" />
            </div>
        </div>
        <div class="min-w-0 flex-1">
            <div class="flex flex-col">
                <textarea rows="1"
                    wire:model.lazy="post.content"
                    class="mb-2 w-full bg-bg-3 px-3 py-2 text-typ-2 rounded-xl border-0 border-none focus:ring-0 focus:border-0 focus:outline-0 outline-0 focus:shadow-none resize-none"
                    placeholder="{{ translate('What\'s on your mind?') }}"
                    x-data="{ resizeTextArea: () => { if($el.scrollHeight < 200) $el.style.height = $el.scrollHeight + 'px'; else $el.style.height = '200px'; } }"
                    x-init="resizeTextArea()"
                    @input="resizeTextArea()">
                </textarea>

                <div class="text-14 px-2 py-2 flex justify-between items-center space-x-3 sm:px-3">
                    <x-dashboard.form.image-selector field="thumbnail" id="feed-post-image" :selected-image="$post->thumbnail" template="simple"></x-dashboard.form.image-selector>
                </div>

                <livewire:feed.elements.bookmark></livewire:feed.elements.bookmark>

            </div>
            <div class="mt-3 flex items-center justify-between">
                <p class="group inline-flex items-start text-sm space-x-2 mb-0">
                    @svg('heroicon-s-question-mark-circle', ['class' => 'ftext-10 lex-shrink-0 h-5 w-5 text-typ-3 group-hover:text-typ-4'])
                    <span class="text-10 text-typ-3 group-hover:text-typ-4">
                        {{ translate('Post will be visible publicly') }}
                    </span>
                </p>

                <button class="hidden text-xs text-gray-500" x-on:click="isModalOpen = true">
                   {{ translate('Advanced editor') }}
                </button>

                <button @click="
                        $wire.set('post.thumbnail', thumbnail.id, true);
                    "
                    wire:click="addFeedPost"
                    type="submit"
                    class="btn-primary">
                    {{ translate('Add a post') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Advanced  --}}
    <div x-show="isModalOpen" x-on:click.away="isModalOpen = false" x-cloak x-transition
        class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
            <div
                class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
                <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                    <button type="button"
                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Close</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ translate('Add a post') }}
                        </h3>
                        <div class="mt-2">
                          {{--   <livewire:dashboard.forms.blog-posts.blog-post-form>
                            </livewire:dashboard.forms.blog-posts.blog-post-form> --}}

                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Deactivate</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal End --}}

</div>
