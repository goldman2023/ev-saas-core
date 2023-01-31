<div class="bg-white border border-gray-200 rounded-lg ">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 ">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
              <h4 class="font-semibold">{{ translate('PixPro Sofware Downloads') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-4 py-5 sm:px-6">
        @if($downloads->isNotEmpty())
            <div class="w-full ">
                <div class="flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ translate('Date') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ translate('Item Name') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ translate('Version') }}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ translate('Download') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($downloads as $download)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $download['date'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download['name'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $download['version'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <div class="inline-flex p-2 bg-primary rounded-lg">
                                                    <a href="{{ $download['url'] }}" target="_blank" class="">
                                                        @svg('heroicon-o-download', ['class' => 'h-4 w-4 text-white'])
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- <li class="flow-root">
                <a href="{{ route('my.plans.management') }}" class="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-gray-50">
                    <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg bg-primary">
                        @svg('heroicon-o-list-bullet', ['class' => 'h-6 w-6 text-white'])
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <span>{{ translate('Subscribe to a plan') }}</span>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ translate('Unlock various possibilities by subscribing to a plan of your choice!') }}</p>
                    </div>
                </a>
            </li> --}}
        @endif
    </div>
</div>
