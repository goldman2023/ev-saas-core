
{{-- TODO: Add active state.  --}}

{{-- WIP: Need to check if current_course item is set
    @if($course_item->id == $current_course_item->id)
    active bg-gray-200 rounded p-3
    @endif
--}}
<li class="w-full flex flex-col ">
    <div class="flex items-center justify-between">
        {{-- TODO: Link to chapter if it's free, link to chapter if it's bought, display gated content modal or redirect
        to checkout link in order to buy course --}}
        @if($course_item->children?->isNotEmpty() ?? null)
        <div class="inline-flex items-center text-14">
            {{ $course_item->name }}

        </div>

        @else
        @if($course_item->free || (\Auth::check() && (auth()->user()?->bought($product) ||
        auth()->user()?->manages($product))))
        <a href="{{ route(\App\Models\CourseItem::getRouteName(), [
                    'product_slug' => $product->slug,
                    'slug' => $course_item->slug
                ]) }}" class="inline-flex items-center text-14">

            @if($course_item->type === 'video')
            @svg('heroicon-s-play', ['class' => 'w-4 h-4 mr-2'])
            @elseif($course_item->type === 'wysiwyg')
            @svg('heroicon-o-document', ['class' => 'w-4 h-4 mr-2'])
            @elseif($course_item->type === 'quizz')
            @svg('heroicon-o-pencil', ['class' => 'w-4 h-4 mr-2'])
            @endif

            {{ $course_item->name }}

            @auth
                @if(auth()->user()?->manages($product))
                    @if( $course_item->type === 'quizz')
                        <a class="text-gray-400 text-xs" target="_blank"
                            href="{{ route('dashboard.we-quiz.details', [$course_item->subject_id]) }}">
                            {{ translate('View Results') }} ({{ $course_item->subject->results()->count() }})
                        </a>
                    @else
                        {{-- <a class="text-gray-400 text-xs" target="_blank"
                            href="{{ route('course.item.single', [$product->slug, $course_item->slug]) }}">
                            {{ translate('Preview') }}
                        </a> --}}
                    @endif
                @endif
            @endauth


            @if($course_item->free)
            <span class="badge-success ml-2">{{ translate('Free') }}</span>
            @endif
        </a>
        @else
        <div class="inline-flex items-center text-14 cursor-pointer"
            @click="$dispatch('display-modal', {'id': 'gated-content-cta-modal'})">
            @svg('heroicon-o-lock-closed', ['class' => 'w-4 h-4 mr-2'])


        </div>
        @endif
        @endif

    </div>

    @if($course_item->children?->isNotEmpty() ?? null)
    <ul class="w-full flex-flex-col space-y-2 mt-2 mb-2 pt-2 border-t border-gray-200 pl-4">
        {{-- TODO: Fix ->tree() function when using hasMany relationship! Only then `depth` is available --}}
        {{-- {{ 'p-'.($course_item->children->first()->depth*3) }} --}}
        @foreach($course_item->children as $child)
        @include('frontend.product.single.partials.course-item-list-template', ['product' => $product, 'course_item' =>
        $child])
        {{-- course_item_template($child, $product); --}}
        @endforeach
    </ul>
    @endif
</li>
