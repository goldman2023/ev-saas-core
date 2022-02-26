<div class="hidden w-28 bg-indigo-700 overflow-y-auto md:block">
    <div class="w-full py-6 flex flex-col items-center">
      <div class="flex-shrink-0 flex items-center">
        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white" alt="Workflow">
      </div>
      <div class="flex-1 mt-6 w-full px-2 space-y-1">

        @if(!empty($menu))
            @foreach($menu as $container)
            <!-- Current: "bg-indigo-800 text-white", Default: "text-indigo-100 hover:bg-indigo-800 hover:text-white" -->
        
            <a href="#" wire:click="changePage('{{ $container['slug'] ?? '' }}')" class="text-indigo-100 hover:bg-indigo-800 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
                <!--
                  Heroicon name: outline/home
      
                  Current: "text-white", Default: "text-indigo-300 group-hover:text-white"
                -->
                @svg($container['icon'], 'w-[26px] h-[26px] text-indigo-300 group-hover:text-white')
                <span class="mt-2 text-center">{{ $container['title'] }}</span>
              </a>
            @endforeach
        @endif
        
      </div>
    </div>
  </div>