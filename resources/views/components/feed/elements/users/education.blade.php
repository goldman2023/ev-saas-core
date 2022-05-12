<div class="w-full bg-white rounded-xl shadow {{ $class }}">
    <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
        <h5 class="text-14 font-semibold">{{ translate('Education') }}</h5>
    </div>

    <div class="px-5 pb-4 flex flex-col ">
        @if(!empty($user->getUserMeta('education')))
            @foreach($user->getUserMeta('education') as $index => $edu)
                <div class="w-full flex flex-col  @if($index !== count($user->getUserMeta('education')) - 1) border-b border-gray-200 pb-3 mb-3 @endif">
                    <strong class="block mb-0 text-16 text-typ-1">{{ $edu['school'] ?? '' }}</strong>
                    <div class="flex flex-row items-center text-14">
                        <strong class="text-typ-2">{{ $edu['field_of_study'] }}</strong>
                        <span class="text-10 text-typ-4 mx-1">•</span>
                        <span class="text-typ-3">{{ $edu['degree_title'] }}</span>
                    </div>
                    <div class="flex flex-row items-center text-12 mt-1">
                        @php
                            $start_end_diff = \Carbon::createFromTimestamp($edu['end_date'])->diff(\Carbon::createFromTimestamp($edu['start_date']));
                            $human_diff = $start_end_diff->y . ' years ' . $start_end_diff->d . ' days';
                        @endphp
                        <span class="text-typ-3">{{ \Carbon::createFromTimestamp($edu['start_date'])->format('M Y').' - '.\Carbon::createFromTimestamp($edu['end_date'])->format('M Y') }}</span>
                        <span class="text-10 text-typ-4 mx-1">•</span>
                        <strong class="text-typ-3">{{ $human_diff }}</strong>
                    </div>
                    
                    @if(!empty($edu['description']))
                        <div class="w-full" x-data="{
                            clamped: true,
                            read_more_visible: false,
                            read_more_text: '{{ translate('Read more') }}',
                            init() {
                                $nextTick(() => {
                                    var element = document.getElementById('education_description_{{ $index }}');
                                    if( (element.offsetHeight < element.scrollHeight) || (element.offsetWidth < element.scrollWidth)){
                                        this.read_more_visible = true;
                                    }
                                });
                            },
                            readMore() {
                                this.clamped = !this.clamped;
                                if(this.clamped) {
                                    this.read_more_text = '{{ translate('Read more') }}'
                                } else {
                                    this.read_more_text = '{{ translate('Read less') }}'
                                }
                            }
                        }" x-init="init()" x-cloak>
                            <p class="w-full mt-2 text-typ-3 text-14 overflow-hidden" :class="{'line-clamp-2':clamped}" id="education_description_{{ $index }}">
                                {{ $edu['description'] }}
                            </p>
                            <span x-text="read_more_text" class="w-full justify-center cursor-pointer text-right text-typ-3 text-12 mt-1" @click="readMore()" :class="{'hidden':!read_more_visible, 'inline-flex':read_more_visible}"></span>
                        </div>
                    @endif
             
                    
                    @if(!empty($edu['certificates']))
                        <div class="w-full flex flex-row items-center mt-2">
                            @foreach($edu['certificates'] as $key => $cert)
                                <a href="{{ Storage::url($cert['file_name']) }}" target="_blank" class="bg-white flex items-center rounded-lg border border-gray-200 p-2">
                                    @svg('heroicon-o-document-text', ['class' => 'w-4 h-4 mr-2 text-typ-2'])
                                    <span class="text-14 text-typ-2">{{ translate('Certificate').' '.($key+1) }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            {{-- Education Empty state --}}
            <div class="col-span-12 relative block w-full bg-white border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                @svg('icomoon-book', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                <span class="mt-2 block text-sm font-medium text-typ-2">{{ translate('No education yet...') }}</span>

                @if($user->id === auth()->user()->id)
                    <a href="{{ route('blog.post.create') }}" class="btn-primary mt-3">
                        {{ translate('Add Education?') }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>