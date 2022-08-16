<div {{ $attributes }} class="bg-white {{ $attributes['class'] }}">
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Select a tab</label>
      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
      <select id="tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        <option @click="current_tab = 'subscriptions'">Subscriptions</option>

        <option @click="current_tab = 'features'">Licenses</option>

        <option @click="current_tab = 'invoices'">Invoices</option>

        <option @click="current_tab = 'features'">Activity</option>

      </select>
    </div>
    <div class="hidden sm:block bg-white">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 pl-3" aria-label="Tabs">
          <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
          <a @click="current_tab = 'subscriptions'" href="#"
          :class="{'border-indigo-500 text-indigo-600':current_tab === 'subscriptions'}"

          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
            {{ translate('Subscriptions') }}

            <!-- Current: "bg-indigo-100 text-indigo-600", Default: "bg-gray-100 text-gray-900" -->
            <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block"
            :class="{'bg-indigo-100 text-indigo-600':current_tab === 'subscriptions'}"
            >52</span>
          </a>

          <a href="#" @click="current_tab = 'licenses'"
          class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
            {{ translate('Licenses') }}

            <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">6</span>
          </a>

          <a href="#" @click="current_tab = 'invoices'"
          :class="{'border-indigo-500 text-indigo-600':current_tab === 'invoices'}"

          class="whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
            {{ translate('Invoices') }}

            <span class="bg-indigo-100 text-indigo-600 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">4</span>
          </a>

          <a href="#" @click="current_tab = 'activity'" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
            {{ translate('Activity') }} </a>
        </nav>
      </div>
    </div>
  </div>
