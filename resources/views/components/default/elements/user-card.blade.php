<div>
    <li class="col-span-1 flex flex-col text-center bg-white rounded-lg border border-gray-200 shadow divide-y divide-gray-200">
        <div class="flex-1 flex flex-col p-8">
            <img class="w-32 h-32 flex-shrink-0 mx-auto rounded-full border object-contain"
                src="{{ $user->getThumbnail() }}"
                alt="">
            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ $user->name .' '.$user->surname }}</h3>
            <dl class="mt-1 flex-grow flex flex-col justify-between">
                <dt class="sr-only">Title</dt>
                @if($user->id == 1)
                    <dd class="text-gray-500 text-sm">{{ get_site_name() }} Customer Support</dd>
                @endif
                <dt class="sr-only">Role</dt>
                <dd class="mt-3">
                    <span class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                    @if($user->id == 1)

                       {{ translate('Responds within 2 minutes') }}
                    @else
                        {{ translate('Online') }}
                    @endif
                </span>

                </dd>
            </dl>
        </div>
        <div>
            <div class="-mt-px flex divide-x divide-gray-200">
                <div class="w-0 flex-1 flex">
                    <button
                    x-on:click="CometChatWidget.openOrCloseChat(true); CometChatWidget.chatWithUser('web_1'); "
                        class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                        <svg class="w-5 h-5 text-gray-400" x-description="Heroicon name: solid/mail"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        <span class="ml-3" >Chat</span>
                    </button>
                </div>
                <div class="-ml-px w-0 flex-1 flex">
                    <div class="flex-1 flex items-center justify-center">
                        @livewire('actions.social-action-button', [
                            'object' => $user,
                            'action' => 'follow',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </li>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
</div>
