<div class="lg:col-span-4">
    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Customer Reviews</h2>
    <div class="mt-3 flex items-center">
        <div>
            <div class="flex items-center">
                @for ($i = 0; $i < $average_rating; $i++)
                    <svg class="flex-shrink-0 h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor

                @for ($i = $average_rating; $i < 5; $i++) 
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
            <p>{{$average_rating}} out of 5 stars</p>
        </div>
        <p class="ml-2 text-sm text-gray-900">Based on {{$count}} reviews</p>
    </div>

    <div class="mt-6">
        <h3 class="sr-only">Review data</h3>

        <dl class="space-y-3">
            @for($i=1 ; $i<6 ; $i++)
            <div class="flex items-center text-sm">
                <dt class="flex-1 flex items-center">
                    <p class="w-3 font-medium text-gray-900">{{$i}}<span class="sr-only"> star reviews</span></p>
                    <div aria-hidden="true" class="ml-1 flex-1 flex items-center">
                        <!-- Heroicon name: solid/star -->
                        <svg class="flex-shrink-0 h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>

                        <div class="ml-3 relative flex-1">
                            <div class="h-3 bg-gray-100 border border-gray-200 rounded-full"></div>

                            <div style="width: calc(<?php echo $each_stars[$i]; ?> * 1%);" class="absolute inset-y-0 bg-yellow-400 border border-yellow-400 rounded-full"></div>
                        </div>
                    </div>
                </dt>
                <dd class="ml-3 w-10 text-right tabular-nums text-sm text-gray-900">{{$each_stars[$i]}}%</dd>
            </div>
            @endfor
        </dl>
    </div>

    <div class="mt-10">
        <h3 class="text-lg font-medium text-gray-900">Share your thoughts</h3>
        <p class="mt-1 text-sm text-gray-600">If you’ve used this product, share your thoughts with other customers</p>

        <button href="#" onclick="openModal()" class="mt-6 inline-flex w-full bg-white border border-gray-300 rounded-md py-2 px-8 items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full">Write a review</button>
    </div>
    
</div>

