<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul>
            @foreach(tenant()->domains as $domain)
            <li
            @if(! $loop->first)
            class="border-t border-gray-200"
            @endif>
            <div class="hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-indigo-600">
                            {{ $domain->domain }}
                        </div>
                        <div class="flex">
                          @if($domain->is_fallback)
                          <div class="ml-2 flex items-center">
                              <span class="px-2 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                  Fallback
                              </span>
                          </div>
                          @else
                            @if($domain->certificate_status === 'issued')
                                <div class="mr-2 flex items-center">
                                    <span class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Certificate issued
                                    </span>
                                </div>
                                <span class="rounded-md shadow-sm">
                                    <button type="button" wire:click="revokeCertificate({{ $domain->id }})" class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                        Revoke certificate
                                    </button>
                                </span>
                            @elseif($domain->certificate_status === 'pending')
                                <div class="mr-2 flex items-center">
                                    <span class="px-2 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Pending
                                    </span>
                                </div>
                            @else
                                @if($domain->certificate_status === 'revoked')
                                    <div class="mr-2 flex items-center">
                                        <span class="px-2 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Certificate revoked
                                        </span>
                                    </div>
                                @endif
                                <span class="rounded-md shadow-sm">
                                    <button type="button" wire:click="requestCertificate({{ $domain->id }})" class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                        Request certificate
                                    </button>
                                </span>
                            @endif
                          @endif
                          @if($domain->is_primary)
                          <div class="ml-2 flex items-center">
                              <span class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                  Primary
                              </span>
                          </div>
                          @else
                          <div class="ml-2 flex">
                              <span class="rounded-md shadow-sm">
                                  <button type="button" wire:click="makePrimary({{ $domain->id }})" class="items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                      Make primary
                                  </button>
                              </span>
                              @if(! $domain->is_fallback)
                              <span class="ml-2 rounded-md shadow-sm">
                                  <button id="delete_{{ $domain->id }}" name="delete_{{ $domain->id }}" type="button" wire:click="delete({{ $domain->id }})" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
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
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <div class="ml-1">
                                    {{ ucfirst($domain->type) }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
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