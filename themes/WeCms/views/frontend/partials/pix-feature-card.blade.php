<div class="col-span-1">
    <div class="flow-root bg-white rounded-lg border border-gray-200 hover:shadow-lg h-full pb-6 overflow-hidden">
      <div class="w-full">
          <div class="w-full aspect-square inline-flex items-center justify-center rounded-md ">
            <img src="{{ IMG::get($data['image']['file_name'], IMG::mergeWithDefaultOptions($data['image']['options'] ?? [], 'original')) }}" alt="{{ $data['image']['alt_text'] ?? '' }}" 
                  class="w-full object-cover" />
          </div>

        <div class="w-full text-left px-6">
          @if(!empty($data['title'] ?? null))
            <h3 class="mt-6 text-20 font-medium tracking-tight text-gray-900">
              {{ $data['title'] }}
            </h3>
          @endif

          @if(!empty($data['text'] ?? null))
            <p class="mt-3 text-base text-gray-500 line-clamp-5">
              {{ $data['text'] }}
            </p>
          @endif
        </div>
      </div>
    </div>
</div>