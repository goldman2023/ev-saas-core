<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <h2 class="mb-3">{{ translate('Marketplace Domains') }} </h2>
        <ul class="list-group">
            @foreach (tenant()->domains as $domain)
                <li class="list-group-item">
                    <div
                        class="hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600">
                                    {{ $domain->domain }}
                                </div>
                                <div class="flex">
                                    @if ($domain->is_fallback)
                                        <div class="ml-2 flex items-center">
                                            <span
                                                class="px-2 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Fallback
                                            </span>
                                        </div>
                                    @else
                                        @if ($domain->certificate_status === 'issued')
                                            <div class="mr-2 flex items-center">
                                                <span
                                                    class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Certificate issued
                                                </span>
                                            </div>
                                            <span class="rounded-md shadow-sm">
                                                <button type="button"
                                                    wire:click="revokeCertificate({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Revoke certificate
                                                </button>
                                            </span>
                                        @elseif($domain->certificate_status === 'pending')
                                            <div class="mr-2 flex items-center">
                                                <span
                                                    class="px-2 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Pending
                                                </span>
                                            </div>
                                        @else
                                            @if ($domain->certificate_status === 'revoked')
                                                <div class="mr-2 flex items-center">
                                                    <span
                                                        class="px-2 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Certificate revoked
                                                    </span>
                                                </div>
                                            @endif
                                            <span class="rounded-md shadow-sm">
                                                <button type="button"
                                                    wire:click="requestCertificate({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Request certificate
                                                </button>
                                            </span>
                                        @endif
                                    @endif
                                    @if ($domain->is_primary)
                                        <div class="ml-2 flex items-center">
                                            <span
                                                class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Primary
                                            </span>
                                        </div>
                                    @else
                                        <div class="ml-2 flex">
                                            <span class="rounded-md shadow-sm">
                                                <button type="button" wire:click="makePrimary({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Make primary
                                                </button>
                                            </span>
                                            @if (!$domain->is_fallback)
                                                <span class="ml-2 rounded-md shadow-sm">
                                                    <button id="delete_{{ $domain->id }}"
                                                        name="delete_{{ $domain->id }}" type="button"
                                                        wire:click="delete({{ $domain->id }})"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                        Delete
                                                    </button>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="">
                                    <div class="mr-6 flex items-center text-sm text-gray-500">
                                        <div class="ml-1">
                                            {{ ucfirst($domain->type) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                    <div class="ml-1">
                                        Added on
                                        <time datetime="{{ $domain->created_at->format('Y-m-d') }}">
                                            {{ $domain->created_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <h2> {{ translate('Vendor Domains') }} </h2>
        <ul class="list-group">
            @foreach (tenant()->vendor_domains as $domain)
                <li class="list-group-item">
                    <div
                        class="hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600">
                                    {{ $domain->domain }}
                                </div>
                                <div class="flex">
                                    @if ($domain->is_fallback)
                                        <div class="ml-2 flex items-center">
                                            <span
                                                class="px-2 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Fallback
                                            </span>
                                        </div>
                                    @else
                                        @if ($domain->certificate_status === 'issued')
                                            <div class="mr-2 flex items-center">
                                                <span
                                                    class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Certificate issued
                                                </span>
                                            </div>
                                            <span class="rounded-md shadow-sm">
                                                <button type="button"
                                                    wire:click="revokeCertificate({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Revoke certificate
                                                </button>
                                            </span>
                                        @elseif($domain->certificate_status === 'pending')
                                            <div class="mr-2 flex items-center">
                                                <span
                                                    class="px-2 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Pending
                                                </span>
                                            </div>
                                        @else
                                            @if ($domain->certificate_status === 'revoked')
                                                <div class="mr-2 flex items-center">
                                                    <span
                                                        class="px-2 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Certificate revoked
                                                    </span>
                                                </div>
                                            @endif
                                            <span class="rounded-md shadow-sm">
                                                <button type="button"
                                                    wire:click="requestCertificate({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Request certificate
                                                </button>
                                            </span>
                                        @endif
                                    @endif
                                    @if ($domain->is_primary)
                                        <div class="ml-2 flex items-center">
                                            <span
                                                class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Primary
                                            </span>
                                        </div>
                                    @else
                                        <div class="ml-2 flex">
                                            <span class="rounded-md shadow-sm">
                                                <button type="button" wire:click="makePrimary({{ $domain->id }})"
                                                    class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                    Make primary
                                                </button>
                                            </span>
                                            @if (!$domain->is_fallback)
                                                <span class="ml-2 rounded-md shadow-sm">
                                                    <button id="delete_{{ $domain->id }}"
                                                        name="delete_{{ $domain->id }}" type="button"
                                                        wire:click="delete({{ $domain->id }})"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                        Delete
                                                    </button>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="">
                                    <div class="mr-6 flex items-center text-sm text-gray-500">
                                        <div class="ml-1">
                                            {{ ucfirst($domain->type) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                    <div class="ml-1">
                                        Added on
                                        <time datetime="{{ $domain->created_at->format('Y-m-d') }}">
                                            {{ $domain->created_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
