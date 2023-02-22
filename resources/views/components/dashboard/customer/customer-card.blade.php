<div class="w-full flex flex-col bg-white border border-gray-300 p-4 mb-3 rounded-lg">
    <div class="grid grid-cols-4 gap-3">
        <div class="col-span-1">
            <a href="{{ route('user.details', $user->id) }}">

                <img class="mb-2 w-20 rounded shadow-md shadow-gray-300" src="{{ $user->getThumbnail() }}">
            </a>
        </div>

        <div class="col-span-3">
            <h2 class="text-lg font-medium">
                <a href="{{ route('user.details', $user->id) }}">
                    {{ $user->fullName }}
                </a>
            </h2>
            <ul class="mt-1 space-y-1">
                <li class="flex items-center text-sm font-normal text-gray-500">
                    @if($user->entity === 'company')
                    @svg('heroicon-o-building-office-2', ['class' => 'mr-2 w-4 h-4'])
                    @else
                    @svg('heroicon-o-user', ['class' => 'mr-2 w-4 h-4'])

                    @endif

                    @if($user->entity === 'company')
                    @if(!empty($user->getUserMeta('company_name')))
                    {{ $user->getUserMeta('company_name', translate('Company')) }}
                    @else
                    {{ translate('Company') }}
                    @endif
                    @else
                    {{ translate('Individual') }}
                    @endif
                </li>
                {{-- <li class="flex items-center text-sm font-normal text-gray-500">
                    <svg class="mr-2 w-4 h-4 text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    San Francisco, USA
                </li> --}}
            </ul>
        </div>
    </div>
    <div class="mb-4 sm:flex xl:block">
        <div class="sm:flex-1">
            <address class="text-sm not-italic font-normal text-gray-500">
                <div class="mt-4">{{ translate('Email adress') }}</div>
                <a class="text-sm font-medium text-gray-900" href="mailto:{{ $user->email }}">
                    {{ $user->email }}
                </a>

                <div class="mt-4">{{ translate('Phone number') }}</div>
                <div class="mb-2 text-sm font-medium text-gray-900">
                    @if(!empty($user->phone))
                    {{ $user->phone }}
                    @else
                    /
                    @endif
                </div>
            </address>
        </div>
    </div>

    @me($user)
    <div class="flex space-x-3">
        <div class="w-full grid grid-cols-1 gap-3">
            <a href="{{ route('my.account.settings') }}"
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                @svg('heroicon-o-user-circle', ['class' => '-ml-1 mr-2 h-5 w-5 text-gray-400'])

                <span>
                    {{ translate('My account') }}
                </span>
            </a>
        </div>
    </div>
    @else
    @admin
    <div x-data="{
                add() {
                    $dispatch('display-modal', {'id': 'notification-modal'})
                }
            }">
        <h3 class="mb-2 text-base font-bold text-gray-900">
            {{ translate('Actions') }}
        </h3>
        <div class="flex space-x-3">
            <div class="w-full grid grid-cols-1 gap-3">
                <button type="button" @click="add()"
                    class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" x-description="Heroicon name: mini/envelope"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z">
                        </path>
                        <path
                            d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z">
                        </path>
                    </svg>
                    <span>
                        {{ translate('Email') }}
                    </span>
                </button>

                <livewire:notification-modal />




                <a type="button" href="tel::{{ $user->phone }}"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" x-description="Heroicon name: mini/phone"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>
                        {{ translate('Call') }}
                    </span>
                </a>

                <a href="{{ route('order.create', $user->id) }}" type="button"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                    @svg('heroicon-o-plus', ['class' => '-ml-1 mr-2 h-5 w-5 text-gray-400'])

                    <span>
                        {{ translate('New Order') }}
                    </span>
                </a>
            </div>
        </div>
    </div>
    @endadmin
    @endme

</div>
