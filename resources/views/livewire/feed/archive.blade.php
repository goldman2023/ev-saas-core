<div role="list" class="grid grid-cols-2 gap-5 md:grid-cols-4" x-data="{
    page: @entangle('page'),
}">
    @foreach ($items as $item)
        {{-- Add conditionals to specify which card template is used base on Model class --}}
        <livewire:feed.elements.product-card :product="$item"></livewire:feed.elements.product-card>
    @endforeach

    {{-- {{ $items->links() }} --}}
    <div class="w-full mt-5 flex-1 flex">
        @if ($page <= 1)
          <div class="mr-2 opacity-50 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </div>
        @else
          <div @click="page = Number(page) - 1" class="mr-2 cursor-pointer relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </div>
        @endif

        @if ($page == $lastPageNumber)
          <div class="mr-2 opacity-50 rml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </div>
        @else
          <div @click="page = Number(page) + 1" class="cursor-pointer rml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </div>
        @endif
    </div>
</div>