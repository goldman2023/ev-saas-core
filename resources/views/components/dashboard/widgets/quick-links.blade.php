<div>
    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">
       {{ translate('Quick Links') }}
    </h2>

<div class="gap-3 grid grid-cols-2">

    @foreach($links as $link)
    <a href="#" class="w-full inline-flex items-center justify-center py-2.5 px-3 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
       <span class="w-5 h-5 mr-2 text-gray-900 dark:text-white">
        @svg($link['icon'])
       </span>

        {{ $link['title'] }}
    </a>
    @endforeach

</div>

</div>
