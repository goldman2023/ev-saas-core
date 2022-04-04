<div class="bg-gray-50 px-4 py-6 sm:px-6 rounded-lg">
    <div class="flex space-x-3">
        <div class="flex-shrink-0 ">
            <img class="object-contain h-20 w-20 rounded-full bg-white we-feed-avatar ring-gray-900 ring-2"
                src="{{ auth()->user()->getThumbnail() }}"
                alt="">
        </div>
        <div class="min-w-0 flex-1">
            <h3 class="text-2xl md:text-xl font-semibold tracking-tight leading-7 md:leading-snug truncate ng-star-inserted">
              {{ translate('Welcome to ') }} {{ get_site_name() }} {{ translate('community') }}, <br>
              {{ auth()->user()->name }}
              <span class="emoji ml-2">👋</span></h3>
        </div>
    </div>
</div>
