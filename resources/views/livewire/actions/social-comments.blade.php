<div class="w-full">
    @auth
        {{-- Add comments to ACTIVITY POST! --}}
        @if(!is_null($replyCommentId))
            <h3 class="text-14 mt-2 mb-2">{{ is_null($replyCommentId) ? '' : translate('Replying to a comment') }}</h3>
        @endif

        <div class="flex items-start" wire:target="save_comment" wire:loading.class="pointer-events-none opacity-40">
            <div class="shrink-0 pr-3 mt-1">
                <img src="{{ auth()->user()->getThumbnail(['w' => 65]) }}" class="h-[32px] w-[32px] object-cover border border-gray-200 rounded-full"/>
            </div>
            <div class="grow flex flex-col">
                <textarea wire:model.defer="comment_text" class="mb-2 w-full bg-bg-3 px-3 py-2 text-typ-3 rounded-xl border-0 border-none focus:ring-0 focus:border-0 focus:outline-0 outline-0 focus:shadow-none resize-none"
                        rows="1"
                        placeholder="{{ translate('Write your comment…') }}"
                        x-data="{ resizeTextArea: () => { if($el.scrollHeight < 200) $el.style.height = $el.scrollHeight + 'px'; else $el.style.height = '200px'; } }"
                        x-init="resizeTextArea()"
                        @input="resizeTextArea()"
                ></textarea>

                <x-system.invalid-msg field="comment_text" class="mb-2"></x-system.invalid-msg>

                <button type="button" wire:click="save_comment()"
                    class="ml-auto inline-flex items-center px-3 py-1 border border-transparent text-12 text-primary bg-primary-light rounded">
                    {{ translate('Post') }}
                </button>
            </div>
        </div>
    @endauth

    {{-- <div class="we-comments-list"> --}}
        {{-- <div class="mt-3 flex items-start space-x-4 mb-6">
            <div class="flex-shrink-0">
                <img class="inline-block h-10 w-10 rounded-full" src="{{ auth()->user()->getThumbnail() }}" alt="">
            </div>
            <div class="min-w-0 flex-1">
                @if(!is_null($replyCommentId))
                <h3 class="text-sm mt-2 mb-2">{{ is_null($replyCommentId) ? '' : 'Replying to a comment' }}</h3>
                @endif
                <div wire:submit.prevent class="relative"> --}}
                    {{-- @if($reviews)

                    <div class="mb-3">
                        <label class="text-base font-medium text-gray-900">{{ translate('Rating') }}</label>
                        <p class="text-sm leading-5 text-gray-500">{{ translate('How would you rate this product?') }}
                        </p>
                        <fieldset class="">
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                @for($i = 1; $i <= 5; $i++) <div class="flex items-center">
                                    <input id="email" name="rating" type="radio" checked
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="email" class="ml-3 block text-sm font-medium text-gray-700"> {{ $i }}
                                    </label>
                            </div>
                            @endfor
                    </div>
                    </fieldset>
                </div>


                @endif --}}
                {{-- <div
                    class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                    <label for="comment" class="sr-only">
                        {{ translate('Add your comment') }}
                    </label>


                    <textarea wire:model.defer="comment_text" rows="2" name="comment" id="comment"
                        placeholder="Add your comment..."
                        class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm">
                    </textarea>

                    <!-- Spacer element to match the height of the toolbar -->
                    <div class="py-2" aria-hidden="true">
                        <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                        <div class="py-px">
                            <div class="h-9"></div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 inset-x-0 pl-3 pr-2 py-2 flex justify-between">
                    <div class="flex items-center space-x-5">
                        <div class="flex items-center">
                            <button type="button"
                                class="-m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500">
                                <!-- Heroicon name: solid/paper-clip -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Attach a file</span>
                            </button>
                        </div>

                    </div>
                    <div class="flex-shrink-0">
                        <button type="button" wire:click="save_comment()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Post
                        </button>
                    </div>
                </div> --}}
            {{-- </div>
        </div> --}}
    {{-- </div> --}}

    @auth
    @forelse ($comments as $comment)
        <div class="mb-2 mt-4">
            <div class="flex items-start">
                <div class="shrink-0 pr-3 mt-1">
                    <img src="{{ auth()->user()->getThumbnail(['w' => 65]) }}" class="h-[32px] w-[32px] object-cover border border-gray-200 rounded-full"/>
                </div>
                <div class="grow flex flex-col bg-bg-3 p-4 rounded-xl">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="text-14 font-bold text-typ-2">
                            {{ $comment->user->name }}
                        </h4>

                        <span class="text-12 text-typ-3">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="w-full text-14 text-typ-3">
                        {{ $comment->comment_text }}
                    </p>
                </div>
            </div>

            {{-- <a wire:click.prevent="reply({{ $comment->id }})" href="#"
                style="text-decoration: underline; font-size: 12px">Reply
                to this comment</a> --}}
        </div>

        {{-- @foreach ($comment->replies as $reply)
            <div style="padding-left: 30px;" class="mb-3">
                <div class="flex items-center">
                    <img src="{{ $reply->user->getThumbnail() }}" alt="{{ $reply->user->name }}" class="h-12 w-12 rounded-full">
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-gray-900">
                            {{ $reply->user->name }}
                        </h4>
                        <span class="text-xs gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>

                </div>
                {{ $reply->comment_text }}
            </div>
        @endforeach --}}
    @endforeach
    @endauth

    @if($hasMorePages && !empty($nextCursor))
    <div class="w-full flex justify-between mt-4">
        <span class="text-12 text-typ-3 cursor-pointer" wire:click="loadComments()">{{ translate('View more comments') }}</span>

        {{-- TODO: Repalce with $item->comments_count once it starts working! --}}
        <span class="text-12 text-typ-3">{{ (($this->page-1) * $this->perPage).' of '.$item->comments()->count() }}</span>
    </div>
    @endif
</div>
