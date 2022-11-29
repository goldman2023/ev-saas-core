<div>
    <div class="{{ $containerClass }}" x-data="{
    displayModal: {{ $displayModal }},
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
    }
}" @display-media-editor-modal.window="displayModal = true;" x-show="displayModal" x-cloak>
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
                    @svg('heroicon-o-x', ['class' => 'w-5 h-5 text-gray-500'])
                </button>

                <div class="flex flex-col max-h-[85vh]" x-data="{}">
                    <!-- Modal content -->
                    <div class="relative py-2 bg-white rounded-lg dark:bg-gray-800 sm:py-0">

                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between pb-4 mb-4 border-b border-gray-200 rounded-t sm:mb-5 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ $upload?->file_original_name ?? ''}}
                            </h3>
                        </div>


                        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                            <div>
                                {{-- Upload Details --}}
                                <div class="overflow-hidden bg-white shadow border border-gray-300 sm:rounded-lg">
                                    <div class="px-4 py-5 sm:px-6">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('File
                                            Details')
                                            }}</h3>
                                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('All information
                                            about
                                            the upload/file can be viewed and edited here.') }}</p>
                                    </div>
                                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('File ID') }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $upload?->id ?? '' }}</dd>
                                            </div>

                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('File Name')
                                                    }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $upload?->file_original_name
                                                    ??
                                                    ''}}</dd>
                                            </div>

                                            <div class="col-span-1 sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('File URL')
                                                    }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    <a href="{{ $upload?->url() ?? '#' }}" target="_blank"
                                                        class="text-sky-600">
                                                        {{ $upload?->url() ?? '#' }}
                                                    </a>
                                                </dd>
                                            </div>

                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('Type') }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $upload?->type ?? '' }}</dd>
                                            </div>
                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('Extension')
                                                    }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $upload?->extension ?? '' }}
                                                </dd>
                                            </div>

                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('File size')
                                                    }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{
                                                    formatSizeUnits($upload?->file_size ?? 0) }}</dd>
                                            </div>

                                            <div class="sm:col-span-1">
                                                <dt class="text-sm font-medium text-gray-500">{{ translate('Uploaded
                                                    on') }}
                                                </dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{
                                                    $upload?->created_at?->format('d
                                                    M, Y H:i') ?? '' }}</dd>
                                            </div>

                                            {{-- <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">About</dt>
                                                <dd class="mt-1 text-sm text-gray-900">Fugiat ipsum ipsum deserunt culpa
                                                    aute sint do nostrud anim incididunt cillum culpa consequat.
                                                    Excepteur
                                                    qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud
                                                    in
                                                    ea officia proident. Irure nostrud pariatur mollit ad adipisicing
                                                    reprehenderit deserunt qui eu.</dd>
                                            </div> --}}
                                        </dl>

                                        <div class="relative py-5 mt-2">
                                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                <div class="w-full border-t border-gray-300"></div>
                                            </div>
                                            <div class="relative flex justify-center">
                                                <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Other
                                                    information') }}</span>
                                            </div>
                                        </div>

                                        {{-- Other Information (WEF & CoreMeta)--}}
                                        <div class="grid grid-cols-1 gap-y-3 mb-6">
                                            @php
                                            do_action('view.dashboard.we-media-editor.other-information', $upload,
                                            $subject);
                                            @endphp
                                        </div>
                                        {{-- END Other Information (WEF & CoreMeta) --}}
                                        <div>
                                            {{-- Download button --}}
                                            <div class="flex gap-3 items-center align-center">
                                            <button class="btn btn-primary mb-3">
                                                {{ translate('Download') }}
                                                @svg('heroicon-o-download', ['class' => 'w-8 h-8 mr-3 text-white'])

                                            </button>
                                            <div> {{ translate('- or -')}} </div>

                                            <button class="btn bg-gray-200 mb-3">
                                                {{ translate('Share') }}
                                                @svg('heroicon-o-share', ['class' => 'w-6 h-6 text-gray-700'])

                                            </button>

                                        </div>

                                            {{-- TODO: Add feature detection for google drive --}}
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-green-500"
                                                    x-description="Heroicon name: mini/check"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <p class="ml-2 text-sm text-gray-500">
                                                    {{ translate('Synced with Google Drive') }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                {{-- END Upload Details --}}

                                {{-- Upload actions --}}
                                <div class="mt-6">
                                    {{-- TODO Add feature detection for smart ID and Types --}}
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                        @click="loading = true"
                                        class="w-full bg-gray-200 inline-flex items-center justify-center py-2.5 px-5 text-lg font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <img class="mr-2 w-5 h-5"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOIAAADfCAMAAADcKv+WAAAAYFBMVEX///8Ar6oArKed2deCzssAqqX4/f38///h9PPc8vG85eMAsazC5+bu+flzysfz+/svt7NRwLzS7u2s39234+HU7+6Z19VexMDl9fWQ1NF+zsun3NpFvbnJ6ulsyMUqtrLV8KuPAAAMlElEQVR4nN2daWOzKhCFDZFmMZvNapom//9fXjVt4xkQWQbJfc/HNlGfAMPMMGCWxdX2cznN77uJVo/z9bT83EZ+hIi6LKuyEFLU0hPWqv8nRXHL94vUT+uh74c0sVFSKW/5cp36oZ1USUs6aNFHvpqlfnJbLd0Jn5hSnPf/j8Ys/Ah/GnN3uqQGGNS3ZyO+GvO2/0gNYdaXrZ0xNebmmBrDpGk4YtOUu31qkH6xIDaU4vSu/ZULsYGs3tP70SOKl1wgZf6OswgiNk6amDxu5X1zvebXWvfbo2g8GjtYIfL3a0lAvH0tFxfNkFrPj4fp/VY0pIOQp3fzerqIIh/48Hp1OhdDmKI4jPLk1nJCbHU5bAYw5W0e+7Fd5I7Y6LIv61Hb35CyivnMjvJDrPWx2hgoRfEd7ZFd5Y3YaHXv77Dy/i5mJwgxy7b7R19Tikn0hpzt7/fNcuhTgYi1jr1NGXtE7lsXRe4GjFs4Yj2X5D2Q4hbR25mdf+NAaWbkQKxtT6WHFGLle8khLR6vO+6Mn+RB7IeM1VkP3VBeGkc9F2JteSqt4ZFljCArh2SF+cH5EOsxeddlSUTBn945443E2fRhTsQs+3zoGlIwzx5behdxN32cFzHLTrohKVnTHpeC3kJ8mT7PjZhdbpreKjmu/KNP9frCGKSyI9YzsqYh5Ybl0rVWmoufjN+IgJhtNQ1pHi72OqiXlgOXjoFYj0gNo9Hq2WqvIZwOfCcOYnZUTAILo9qGohhcDIyEmM1K9WmCGVVCWQ6HbLEQqQPSXj9wPK5UQhv3MB6i7jcPsqvqbCEHY8VGERGzxYQOyBCnfK6ObrvVopiI2Vrx56TRDzFpqwAWlsFoVMRstlMYfQNIeiWxs827x0XMslLxJ/0qPs6U8Gb91diIyrNNJj7xI625cCCMjxjy+/+J1lw4XSM+osroPHXMKaE5WUM0AqIyHqXjus6soIROWegxELMbbUe3ZZ07+XrhNppHQczo/Phw+bLiJTkmZ8dBpPO2y3C80G7uurI3DqL6nFbeZSvSyx2++aORENUowXY8TfGLA0kM7RVGQqSJANvgkTS/T8w5GiKdHi07HOmmTnbqR+MhZg+PrkqsqfBJrI+IeCGPa2FVP0jLe6WcR0Sk6TM5HNFusPDJL/kzJiIdjoOe5gJ/k8KvemBUxA8cjIMpANxRYV5F7NeoiHR2FOZmQVvjHqD8aFxE0lUHbogBhmc3HR2RdFXjJIA13d5Jn7ERaeczJI9nHNa00diIxF0xhA0VIvqXt7gifoQWJ2CSor9xsEuLgByzE+KyFFJOzmFL9zk2Y1/O8QQfKwJu6IC43j2rToTNclC/LMcY/hAhVbz2iOvXCoV4hHTXqc1oRHPqlHEz3c+M2M24hy0VwnzXM6NDWOLr1zxljYjWXn4G3BPdcW25BbpBQY1oj4jG3tubaoXNqDOWN/g9w2oFrRFJ7iXohyVRlfqBC2MjWiOuaXopqCwamlGT4oBpP8icZv6I3k5xK7CXolT+j7cKuVPm0FFJIjSw88C1JHXGYd+oGKqrGZI1olMYNCjoiYrBgUUMEeoyWiPijlzlh3fU2uSeQVIqzHY3sp/6u80or6H3hU5BZtkD/C/4qAR7xE5pggyv9cLhhr8YrEcGDvrMLdLYtG644NkRhVmL7n8+WI2NYzC1qGqvo+TZyl/19lTopwGh8K9Gj/p/BaEx3Lk7TDVzprOSIWKStLMcA/GkYKgqT4cIYWMnagRDJBm2JqdDxJ76SozDIPWo0VGUDhGi3k6M3e3A5t0JlkqIiE7c71+30E85NiUnRMRB9+vELLvgoUFGq4SIELz8TfHdHKQI9hMbpUTsOmp/gxGGonMBik4pEaeaPglJcI4pIy3iEaaNtfq3cBe8UUpE8GN+0mzdlEd4qNgqJSKkEn9C/24BA4f3liVGzFV706UOj4ZbJUU8qPYG+i7P+Q5JEaHopAWCHLFPNZhGSRFnin/T9XiYrE1aRMhutPM8GFT3ukyt0iLeKVHXNefxbVIjVvTukMlkOok1LWLXpLZpGpgpmQ4jS4u4ou5ad3CGrQy9lBYRkhs1EjjhPB5qakQI8euOuWXOL7ZKi0hDp+7Mz3USQGJESFHJC4RSIQVToMSI3RhfHtG5YZr5UyNCYPENuSmWBGOjxIiQvlkhItcJMokRz+iwASLX6ZWJEe+IeIjgoqZG3GCz7f9BxCsOvq/0iIvpZsN6qv0VTeg+9Vhcl+37KDgPkiIJt9SI699jenx25vfojkyHxJPGqyiFb9DeDZPG+FN/97gZrmjVOC+Gl6M8ZY/YTUIEFsG+RLybxD5qHqMTER8VegrXaPBE5OpEEEwtIHecIF6MgQinZ8g1FPYmiPpjIGJZJiY2EuRuYiBeSHoqcQYuBuI3XaWBlX6m43HTIkIFSuMzdScRlqKbLDVid3tbuxCV4zzJorSI4IWf6OMw3SQtIgy9JrIAD46lsCg1Iix7N4c1wLoxU0CTFPGilp7CCgDLTdIiwsLUs5wB3B0ek5oUEQzq018j0RWHkiKe1ZufrJ/HWkkRoZrhmapZ8dublIhobZ67P2AzFY8LlxIRiqd+N9yAvQnZsfynlIgb1dqQhBXLEmNKRBiKv5ka2KDKEjImRIRahr8+OdfU4YYpISJuKP7786T7V46ZMSFiqRuKZDBypKjSIWLe5nVB3NvHkNxIh9i3nRZmRo6cdDpE2E3c3VYDdXAMPTUZIvbTbvQ7Ze6pyRCxn3ZPe0G/LtymJkPEY6jhX5DuCM+Jp0KEMzvIiMP9qcGzfyrEqrefkp4a7qemQuzf1p+RA32C9zAmQoTIV8km7qGJQw1OIsSyZ95/Cg+3DQ030iDi2a4qA5xuGxoYp0HEA23U6hPc2Rh4aEkSRDwMXOfAwNENgRs2YBHBWCPBiAj9ULt0cWBsxu4UbD4Cmg8Rj+rSH4CEZ4yFpcVfhXYDdV98iNiI+iY6WXzGWr91X2LgPRVsiDgSe85bxHkj1KhunvWJ5UDRFxvi2WrWy1nnxss0z6tBq8WFeMSR2Oe74BljoSf62YkLERxQQ/NcgZGrQsUoJkQ8ctKQm4H9VOMUdfMgzqANjWOMHGrMVKJiEg/i1cacPkXeNMFXytwrFkS0NQNZC3KoMVeBaL9YEPHNKEPOJ8bNLAscRnEgkhPdh5KkeNQlY9V9jxgQydtMhyvM0UvweAGTmxgQseMNvjOZzv82r4oJUjgieT2djVOGFie2AxCMSN/eYxXoon3ieQt3r0IRybt4LN0V8q24wzEQkb4n0vakl4oMx7DXQJgViEhepWkfAeJrivxeGGapMER03Fy8avoi1IgmJwiRmBqnA4nI6wkjegAhiN+E0K23kT4ez6wGIBKz6BrDU0sVfqR3j/wRL/iE7odKKT9RpPjYG3FNCd1PBqNDmeVYb1W+iGvSzbyCImKQIzF6Iv7tQP57Oq/Jm769OQqjH+JlQp/NL0iZ0deMxrA5XogLAuh/ft2aXklybeF8yQfxUyH0rzE5SuVa3H6OB6LyvuUgz2SpXO3BtTH9R+6IX+ozBdWz06mjHua8aQBnxDt9okkR+KtPlSvyrnU4Im6pmZ84v4VelYaR6fjNVm6In3SyqMUQ6VUKo9jxpVedEE/Ko0wKlkdRLyzYDsZxQlSHoeAh1NicprMyzR4OiJruxGfflbmj+f1YtuU4ICrvh6sHDNMG9kaKP8HWkPaIX4w+jU5zjSkTBcP0YY94p543p2FvtN3pGvIWvMhqj0he6O4ZWxh1VgfkRMg8sLfaI8IKthBRkruaWalx6MKWWe0Ru94358yMNxGazho4JB0mjcffR9mH4Utr3YCs71j4nzzmgDj//YXjVgTlus7adNfKcxJ28W6eh+LJgunk7z59a2aP9vHE1csfdnPDF9NNvoxe8fSheoo/DyhvHnePcrxWsJZaq9MOksnVNWB+T8T+hmyasqicnNc3RaxHJM3UIuXmYG183haxKUHuh2ze+nmrvq0w3xgxW9+lAbJpTPHY7I9D4c47I9YW/NY7JF+tKR9lvl8t1jpbu52v9rD/9e0Q6yG5G4JsOWtQIYpduble86eu99uuaP8On3xDxNptfVhAvlhf0n7gLRFryJt5TDroXRGz7DhgeP4BxNpuVAUH5Tsj1lqV4ZBsB17H0nq6C6Qco9w+VPPTQ5q8noFGHKHankPzaSk9G1O/H+8t9bG8PoRza4oJT3p9NG1XVdlgWnG2fl7FmLwfT/NDVT5a763Hm2l9u8luM/1kXl4fV9vL96G6nm+0wmXyKDf51/KoddBZ9R+8D4JpoU/PXAAAAABJRU5ErkJggg==" />
                                        Sign with SmartID
                                    </a>
                                    <div class="flex items-center text-center mt-3 w-full">
                                        <img  class="h-5 w-5 flex-shrink-0 text-green-500" src="https://play-lh.googleusercontent.com/3T5x4-AoUeXz_RdptNz3Tu0VJZCiN2ck5knS2RJPai917SXb_4pZ_GPT8E8a4ApnoLg" />

                                        <p class="ml-2 text-sm text-center text-gray-500">
                                            {{ translate('Powered by: ') }} <span class="text-underline">{{translate('Dokobit') }} </span>
                                        </p>
                                    </div>
                                </div>

                            </div>


                            {{-- File Preview --}}
                            <div class="overflow-hidden bg-white shadow border border-gray-300 sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ translate('File Preview')
                                        }}</h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('File/Document preview
                                        can be inspected here') }}</p>
                                </div>
                                <div class="border-t border-gray-200">
                                    <iframe src="{{ $upload?->url() ?? '' }}" style="min-height: 60vh;" title="testPdf"
                                        height="100%" width="100%"></iframe>
                                </div>
                            </div>
                            {{-- END File Preview --}}
                        </div>

                        {{-- WeMediaEditor Actions --}}
                        <div class="flex items-center justify-end">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <button type="button" class="btn-primary">
                                    {{ translate('Save') }}
                                </button>
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
</div>
