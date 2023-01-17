<section class="bg-white dark:bg-gray-900">
    <div class="mx-auto">
        <div class="flex justify-between items-center mb-3">
            @if(!is_null($replyCommentId))
            <h3 class="text-14 mt-2 mb-2">{{ is_null($replyCommentId) ? '' : translate('Replying to a comment') }}</h3>
            @else
            <h2 class="text-lg lg:text-xl font-medium text-gray-900 dark:text-white">
                {{ translate('Comments') }} ({{$item->comments()->count()}})
            </h2>

            @endif
            <div>
                @auth
                <span class="text-sm text-gray-800">
                    {{ translate('Posting as:') }}
                </span>
                <button type="button"
                    class="flex items-center py-2 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <img class="mr-2 w-6 h-6 rounded-full" src="{{ auth()->user()->getThumbnail() }}"
                        alt="User profile image">
                    {{ auth()->user()->full_name }}
                </button>
                @else
                <button type="button"
                    class="py-2 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    {{ translate('Login to comment') }}
                </button>
                @endauth
            </div>
        </div>
        {{-- TODO: Add permission --}}
        @auth
            <div class="mb-4 w-full bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                <div class="py-2 px-4 bg-white rounded-t-lg dark:bg-gray-800">
                    <label for="comment" class="sr-only">Your comment</label>

                    <textarea wire:model.defer="comment_text"
                        class="bg-white px-0 w-full text-sm text-gray-900 border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                        rows="1" placeholder="{{ translate('Write a comment…') }}"
                        x-data="{ resizeTextArea: () => { if($el.scrollHeight < 200) $el.style.height = $el.scrollHeight + 'px'; else $el.style.height = '200px'; } }"
                        x-init="resizeTextArea()" @input="resizeTextArea()"></textarea>

                    <x-system.invalid-msg field="comment_text" class="mb-2"></x-system.invalid-msg>

                </div>
                <div class="flex justify-end items-center py-2 px-3 border-t dark:border-gray-600">
                    <button type="button" wire:click="save_comment()"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        {{ translate('Post') }}
                    </button>
                    <div class="flex pl-0 space-x-1 sm:pl-2">

                    </div>
                </div>
            </div>
        @endauth
        @foreach ($comments as $comment)

        <article class="p-6 mb-6 text-base bg-gray-50 rounded-lg dark:bg-gray-700">
            <footer class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                        <img class="mr-2 w-9 h-9 rounded-full" src="{{ $comment->user->getThumbnail() }}"
                            alt="{{ $comment->user->full_name }}">
                        {{ $comment->user->full_name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                            title="February 8th, 2022">{{ $comment->created_at->diffForHumans() }}</time></p>
                </div>

            </footer>
            <p class="text-gray-500 dark:text-gray-400">
                {{ $comment->comment_text }}
            </p>

            <div class="flex items-center mt-4 space-x-4">

                <livewire:actions.social-action-button wire:key="comment_{{ $comment->id }}" :object="$comment"
                    action="reaction" type="like">
                </livewire:actions.social-action-button>




                <button type="button"
                    class="hidden flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                    <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ translate('Reply') }}
                </button>
            </div>
        </article>
        @endforeach

        @if($hasMorePages && !empty($nextCursor))
        <div class="w-full flex justify-between mt-4">
            <span class="text-12 text-typ-3 cursor-pointer" wire:click="loadComments()">{{ translate('View more
                comments') }}</span>

            {{-- TODO: Repalce with $item->comments_count once it starts working! --}}
            <span class="text-12 text-typ-3">{{ (($this->page-1) * $this->perPage).' of '.$item->comments()->count()
                }}</span>
        </div>
        @endif
    </div>
</section>
