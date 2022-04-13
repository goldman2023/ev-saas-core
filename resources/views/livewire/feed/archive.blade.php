<div class="we-archive w-full flex flex-col">
  <div role="list" class="grid grid-cols-2 gap-5 md:grid-cols-3" x-data="{
      page: @entangle('page'),
  }">

      @foreach ($items->items() as $item)
          @if($item instanceof \App\Models\Product)
            <x-feed.elements.product-card :product="$item"></x-feed.elements.product-card>

          @elseif($item instanceof \App\Models\Plan)
            {{-- Create plan-card component --}}
          @endif
          {{-- <livewire:feed.elements.product-card :product="$item"></livewire:feed.elements.product-card> --}}
      @endforeach

  </div>


  <div class="w-full mt-5 flex-1">
    {{ $items->links() }}
  </div>
</div>
