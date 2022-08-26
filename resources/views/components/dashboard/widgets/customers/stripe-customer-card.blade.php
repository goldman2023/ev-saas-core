<div class="card pb-16 space-y-6 mb-6">
    <div>

        <div class="flex items-start justify-between">
            <div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-4 block w-full aspect-w-6 aspect-h-5 rounded-lg overflow-hidden">
                        <img src="{{ $user->getThumbnail() }}" alt="{{ $user->name }}" class="object-cover w-full h-full">
                    </div>

                    <div class="col-span-8">
                        <h2 class="text-lg font-medium text-gray-900">
                            <span class="sr-only"></span>
                            {{ $user->name }}
                        </h2>
                        <p class="text-sm font-medium text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

            </div>
            <button type="button"
                class="hidden ml-4 bg-white rounded-full h-8 w-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="h-6 w-6" x-description="Heroicon name: outline/heart" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
                <span class="sr-only">Favorite</span>
            </button>
        </div>
    </div>
    <div>
        <div class="mb-3">
            @if($user->user_type === \App\Enums\UserTypeEnum::customer()->value)
            <span class="badge-dark">
                {{ ucfirst($user->user_type) }}
            </span>
            @elseif($user->user_type === \App\Enums\UserTypeEnum::staff()->value)
            <span class="badge-warning">
                {{ ucfirst($user->user_type) }}
            </span>
            @elseif($user->user_type === \App\Enums\UserTypeEnum::seller()->value)
            <span class="badge-info">
                {{ ucfirst($user->user_type) }}
            </span>
            @elseif($user->user_type === \App\Enums\UserTypeEnum::admin()->value)
            <span class="badge-success">
                {{ ucfirst($user->user_type) }}
            </span>
            @endif

            @if($user->entity === \App\Enums\UserEntityEnum::individual()->value)
            <span class="badge-dark">
                {{ ucfirst($user->entity) }}
            </span>
            @elseif($user->entity === \App\Enums\UserEntityEnum::company()->value)
            <span class="badge-info">
                {{ ucfirst($user->entity) }}
            </span>
            @endif


            @if($user->isOnTrial())
            <span class="badge-warning">
                {{ translate('Trial') }}
            </span>
            @elseif($user->isSubscribed())
            <span class="badge-success">
                {{ translate('Full') }}
            </span>
            @else
            <span class="badge-danger">
                {{ translate('No subscription') }}
            </span>
            @endif


        </div>
        <h3 class="font-medium text-gray-900">{{ translate('Summary') }}</h3>

        <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
            @if($user->created_at)
            <div class="py-3 flex justify-between text-sm font-medium">
                <dt class="text-gray-500">{{ translate('Registered') }}</dt>
                <dd class="text-gray-900">{{ $user->created_at->diffForHumans() }}</dd>
            </div>
            @endif

            @if($user->getStripeCustomerId())
            <div class="py-3 flex justify-between text-sm font-medium">
                <dt class="text-gray-500">{{ translate('User Credit Balance') }}

                    <div>
                        <a class="text-gray-600 text-xs" href="{{ $stripe_customer_endpoint }}" target="_blank">
                            {{ translate('View transaction history') }}
                        </a>
                    </div>
                </dt>
                <dd class="text-gray-900 text-right">{{ FX::formatPrice($user_balance) }}

                </dd>

            </div>
            @endif

            <div class="py-3 flex justify-between text-sm font-medium">
                <dt class="text-gray-500">{{ translate('Payments') }}</dt>
                <dd class="text-gray-900">{{ $user->invoices->count() }}</dd>
            </div>
        </dl>
    </div>
    <div class="hidden">
        <h3 class="font-medium text-gray-900">{{ translate('Description') }}</h3>
        <div class="mt-2 flex items-center justify-between">
            <p class="text-sm text-gray-500 italic">Add a description to this image.</p>
            <button type="button"
                class="bg-white rounded-full h-8 w-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="h-5 w-5" x-description="Heroicon name: solid/pencil" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
                </svg>
                <span class="sr-only"></span>
            </button>
        </div>
    </div>
    <div>
        <h3 class="font-medium text-gray-900">{{ translate('Synced with') }}</h3>
        <ul role="list" class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">

            <li class="py-3 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/1024px-Stripe_Logo%2C_revised_2016.svg.png?20210114172858"
                        alt="" class="w-8 h-8 object-contain rounded-full">
                    <p class="ml-4 text-sm font-medium text-gray-900">{{ translate('Stripe') }}</p>
                </div>
                <a target="_blank"
                    href="{{ $stripe_customer_endpoint }}"
                    type="button"
                    class="ml-6 bg-white rounded-md text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ translate('View') }}
                    <span class="sr-only"></span></a>
            </li>

            <li class="py-3 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="data:image/png;base64,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"
                        alt="" class="w-8 h-8 rounded-full">
                    <div class="ml-4 text-sm font-medium text-gray-900">Mailerlite

                        <div>
                            <small class="text-gray-600">
                                {{ translate('Subscriber ID:') }} {{ $user->getCoreMeta('mailerlite_subscriber_id') }}
                            </small>
                        </div>
                    </div>

                </div>
                <a target="_blank"
                    href="https://dashboard.mailerlite.com/subscribers/{{ $user->getCoreMeta('mailerlite_subscriber_id') }}"
                    type="button"
                    class=" ml-6 bg-white rounded-md text-sm font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ translate('View')}}
                    <span class="sr-only"></span>
                </a>
            </li>

            <li class="hidden py-2 flex justify-between items-center">
                <button type="button"
                    class="hidden group -ml-1 bg-white p-1 rounded-md flex items-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span
                        class="w-8 h-8 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400">
                        <svg class="h-5 w-5" x-description="Heroicon name: solid/plus-sm"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="ml-4 text-sm font-medium text-indigo-600 group-hover:text-indigo-500">Share</span>
                </button>
            </li>
        </ul>
    </div>
    <div class="flex">
        <button type="button"
            class="hidden flex-1 bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Download
        </button>
        <a href="/we/admin/resources/users/{{ $user->id }}" type="button" target="_blank"
            class="flex-1 ml-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ translate('Impersonate') }}
        </a>
    </div>
</div>
