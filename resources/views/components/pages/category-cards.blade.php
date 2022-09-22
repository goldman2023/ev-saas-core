<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
<div class="bg-white">
    <div class="mx-auto max-w-xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-bold tracking-tight text-gray-900">
        {{ translate('Our categories') }}
    </h2>
      <p class="mt-4 text-base text-gray-500">
        {{ translate('Categories Description') }}
        </p>

      <div class="mt-10  lg:grid lg:grid-cols-3 lg:gap-x-8">
        @foreach($categories as $category)
        {{-- TODO: Make this category card component --}}
        <a href="{{ $category->getPermalink() }}" class="group block mb-6">
          <div aria-hidden="true" class="aspect-w-4 aspect-h-2 overflow-hidden rounded-lg group-hover:opacity-75 lg:aspect-w-4 lg:aspect-h-2">
            <img src="{{ $category->getThumbnail() }}" alt="Brown leather key ring with brass metal loops and rivets on wood table." class="h-full w-full object-cover object-center">
          </div>
          <h3 class="mt-4 text-base font-semibold text-gray-900">
            {{ $category->name }}
          </h3>
          <p class="mt-2 text-sm text-gray-500">
            Keep your phone, keys, and wallet together, so you can lose everything at once.
          </p>
        </a>
        @endforeach
      </div>
    </div>
  </div>
