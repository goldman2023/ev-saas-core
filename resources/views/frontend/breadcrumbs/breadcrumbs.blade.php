<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="bg-white border-b border-t border-gray-200 flex" aria-label="Breadcrumb">
    <ol role="list" class="container max-w-7xl w-full mr-auto px-4 flex space-x-4 sm:px-6 lg:px-8">
      <li class="flex">
        <div class="flex items-center">
          <a href="/products" class="text-gray-400 hover:text-gray-500">
            <!-- Heroicon name: solid/home -->
            <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            <span class="sr-only">{{ translate('Shop') }}</span>
          </a>
        </div>
      </li>
      @foreach ($breadcrumbs as $breadcrumb)
      @if (!is_null($breadcrumb->url) && !$loop->last)

      <li class="flex">
        <div class="flex items-center">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
          </svg>
          <a href="{{ $breadcrumb->url }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            {{
                $breadcrumb->title }}
        </a>
        </div>
      </li>


      @else
      <li class="flex">
        <div class="flex items-center">
          <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
          </svg>
          <a href="{{ $breadcrumb->url }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            {{
                $breadcrumb->title }}
        </a>
        </div>
      </li>

      @endif
      @endforeach


    </ol>
  </nav>


