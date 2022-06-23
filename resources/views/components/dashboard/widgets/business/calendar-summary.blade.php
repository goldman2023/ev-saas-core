<!-- This example requires Tailwind CSS v2.0+ -->
<div>
    <div class="flex items-center">
      <h2 class="flex-auto font-semibold text-gray-900">January 2022</h2>
      <button type="button" class="-my-1.5 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Previous month</span>
        <!-- Heroicon name: solid/chevron-left -->
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
      </button>
      <button type="button" class="-my-1.5 -mr-1.5 ml-2 flex flex-none items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Next month</span>
        <!-- Heroicon name: solid/chevron-right -->
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
    <div class="mt-10 grid grid-cols-7 text-center text-xs leading-6 text-gray-500">
      <div>M</div>
      <div>T</div>
      <div>W</div>
      <div>T</div>
      <div>F</div>
      <div>S</div>
      <div>S</div>
    </div>
    <div class="mt-2 grid grid-cols-7 text-sm">
      <div class="py-2">
        <!--
          Always include: "mx-auto flex h-8 w-8 items-center justify-center rounded-full"
          Is selected, include: "text-white"
          Is not selected and is today, include: "text-indigo-600"
          Is not selected and is not today and is current month, include: "text-gray-900"
          Is not selected and is not today and is not current month, include: "text-gray-400"
          Is selected and is today, include: "bg-indigo-600"
          Is selected and is not today, include: "bg-gray-900"
          Is not selected, include: "hover:bg-gray-200"
          Is selected or is today, include: "font-semibold"
        -->
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200">
          <time datetime="2021-12-27">27</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200">
          <time datetime="2021-12-28">28</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200">
          <time datetime="2021-12-29">29</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200">
          <time datetime="2021-12-30">30</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200">
          <time datetime="2021-12-31">31</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class="mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-900 hover:bg-gray-200">
          <time datetime="2022-01-01">1</time>
        </button>
      </div>
      <div class="py-2">
        <button type="button" class=" bg-indigo-600 text-white font-bold mx-auto flex h-8 w-8 items-center justify-center rounded-full text-gray-900 hover:bg-gray-200">
          <time datetime="2022-01-02">2</time>
        </button>
      </div>




    </div>
    <section class="mt-12">
      <h2 class="font-semibold text-gray-900">Schedule for <time datetime="2022-01-21">January 21, 2022</time></h2>
      <ol class="mt-4 space-y-1 text-sm leading-6 text-gray-500">
        <li class="group flex items-center space-x-4 rounded-xl py-2 px-4 focus-within:bg-gray-100 hover:bg-gray-100">
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 flex-none rounded-full">
          <div class="flex-auto">
            <p class="text-gray-900">Leslie Alexander</p>
            <p class="mt-0.5"><time datetime="2022-01-21T13:00">1:00 PM</time> - <time datetime="2022-01-21T14:30">2:30 PM</time></p>
          </div>
          <div class="relative opacity-0 focus-within:opacity-100 group-hover:opacity-100">
            <div>
              <button type="button" class="-m-2 flex items-center rounded-full p-1.5 text-gray-500 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open options</span>
                <!-- Heroicon name: outline/dots-vertical -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
              </button>
            </div>

            <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div class="focus:outline-none absolute right-0 z-10 mt-2 w-36 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-0">Edit</a>
                <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-0-item-1">Cancel</a>
              </div>
            </div>
          </div>
        </li>

        <!-- More meetings... -->
      </ol>
    </section>
  </div>
