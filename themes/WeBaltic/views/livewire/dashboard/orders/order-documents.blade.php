<div class="card mb-9 !p-4 !pt-4 !pb-1">
    <div class="mb-0 dark:border-gray-700">
        <div class="w-full pb-3 mb-2 border-b ">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ translate('Available documents') }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ translate('Here you can find available documents for this order') }}
            </p>
        </div>

        <ul role="list" class="divide-y divide-gray-200 pb-1">
            @if(!empty($documents))
                @foreach($documents as $index => $upload_data)
                    @php
                        $upload_tag = $upload_data['upload_tag'] ?? null;
                        $upload_tag_label = $upload_data['upload_tag_label'] ?? null;
                        $upload = $upload_data['upload'] ?? null;
                    @endphp
                    <li class="flex flex-col">
                        <div target="_blank" class="block hover:bg-gray-50">
                            <div class="flex items-center justify-between py-2">
                                <div class="flex mt-0.5">
                                    <p class="truncate text-sm font-medium text-gray-900 line-clamp-1">{{ $upload_tag_label }}</p>
                                </div>
                                <div class="">
                                    @if($order->getWEF('cycle_status') >= 2)
                                        <div class="btn-primary !py-0.5 !px-2 !text-10 !leading-[1.5] cursor-pointer" >
                                            {{-- @click="$wire.dynamicAction('regenerate_document');" --}}
                                            {{ translate('Generate') }}
                                        </div>
                                    @endif
                                    @if(!empty($upload))
                                        <a href="{{ $upload->url() }}" class="btn-info !py-0.5 !px-2 !text-10 !leading-[1.5]" target="_blank">
                                            {{ translate('Download') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
            
        </ul>
    </div>
</div>