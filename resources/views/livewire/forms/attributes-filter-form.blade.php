<div class="w-full flex flex-col bg-white border rounded-lg border-gray-300 px-3 py-2" x-data="{
    attributes: @entangle('attributes').defer,
    selected_attributes: @entangle('selected_attributes').defer,
}" id="attributes-filter-form" wire:key="attributes-filter-form" :key="'attributes-filter-form'" x-cloak>

    <h3 class="w-full flex items-center justify-between pb-2 mb-2 text-base font-semibold text-gray-900 border-b border-gray-300 px-2 pt-1">
        {{ translate('Filters') }}

        <span class="text-12 text-primary">{{ $count_active_filters.' '.translate('active') }}</span>
    </h3>

    <div class="w-full flex items-center justify-center">
        <div id="accordion-flush" data-accordion="collapse" class="w-full" data-active-classes="text-black dark:text-white"
            data-inactive-classes="text-gray-500 dark:text-gray-400">

            {{-- Attributes --}}
            <template x-for="(attribute, index) in attributes">
                <div class="w-full">
                    <h2 :id="attribute.slug+'-attribute-heading'">
                        <button type="button"
                          class="flex items-center justify-between w-full py-2 px-1.5 text-sm font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                          x-bind:data-accordion-target="'#'+attribute.slug+'-attribute-body'" aria-expanded="false" x-bind:aria-controls="attribute.slug+'-attribute-body'">
                            <span x-text="attribute.name"></span>
                            <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z">
                                </path>
                            </svg>
                        </button>
                    </h2>
                    <div :id="attribute.slug+'-attribute-body'" class="hidden">
                        <div class="py-2 font-light border-b border-gray-200 dark:border-gray-600">

                            {{-- Toggle --}}
                            <template x-if="attribute.type === 'toggle'">
                                <div class="flex items-center" x-data="{
                                    toggle() {
                                        if(_.get(selected_attributes, attribute.slug, false)) { 
                                            {{-- delete selected_attributes[attribute.slug]; --}}
                                            selected_attributes[attribute.slug] = false; 
                                        } else { 
                                            selected_attributes[attribute.slug] = true;
                                        }
                                    },
                                    get isChecked() {
                                        return selected_attributes[attribute.slug] === true;
                                    }
                                }" @click="toggle()">
                                    <button type="button"  class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-0"
                                        :class="{'bg-primary': isChecked, 'bg-gray-200': !isChecked}">
                                      <span aria-hidden="true" class=" pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                        :class="{'translate-x-5': isChecked, 'translate-x-0': !isChecked}"></span>
                                    </button>
                                    <span class="ml-3 cursor-pointer">
                                      <span class="text-sm font-medium text-gray-900" x-text="attribute.name"></span>
                                    </span>
                                </div>
                            </template>
                            {{-- END Toggle --}}

                            {{-- Checkbox --}}
                            <template x-if="attribute.type === 'checkbox'">
                                <div class="flex flex-col" x-data="{}">
                                    <template
                                        x-for="(attribute_value, index) in attribute.attribute_predefined_values"
                                        :key="'we-checkbox-'+attribute_value.id+'-'+index">

                                        <div class="relative flex items-center "
                                            :class="{'!mt-0': index === 0}">
                                            <div class="flex items-center h-6">
                                                <input type="checkbox"
                                                    x-model="selected_attributes[attribute.slug]"
                                                    :value="attribute_value.id"
                                                    :id="'attribute-value_'+attribute_value.id"
                                                    class="form-checkbox-standard focus:ring-0">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label class="font-medium text-gray-700 cursor-pointer"
                                                    x-text="attribute_value.values"
                                                    :for="'attribute-value_'+attribute_value.id"></label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            {{-- END Checkbox --}}

                            {{-- Radio --}}
                            <template x-if="attribute.type === 'radio'">
                                <div class="flex flex-col" x-data="{}">
                                    {{-- All --}}
                                    <div class="relative flex items-center !mt-0">
                                        <div class="flex items-center h-6">
                                            <input type="radio"
                                                x-model="selected_attributes[attribute.slug]"
                                                value="all"
                                                :id="'attribute-value_'+attribute.slug+'_all'"
                                                class="form-radio-standard focus:ring-0">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700 cursor-pointer"
                                                :for="'attribute-value_'+attribute.slug+'_all'">
                                                {{ translate('All') }}
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Each --}}
                                    <template
                                        x-for="(attribute_value, index) in attribute.attribute_predefined_values"
                                        :key="'we-checkbox-'+attribute_value.id+'-'+index">

                                        <div class="relative flex items-center ">
                                            <div class="flex items-center h-6">
                                                <input type="radio"
                                                    x-model="selected_attributes[attribute.slug]"
                                                    :value="attribute_value.id"
                                                    :id="'attribute-value_'+attribute_value.id"
                                                    class="form-radio-standard focus:ring-0">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label class="font-medium text-gray-700 cursor-pointer"
                                                    x-text="attribute_value.values"
                                                    :for="'attribute-value_'+attribute_value.id"></label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            {{-- END Radio --}}

                            {{-- Dropdown - same as checkbox --}}
                            <template x-if="attribute.type === 'dropdown'">
                                <div class="flex flex-col" x-data="{}">
                                    <template
                                        x-for="(attribute_value, index) in attribute.attribute_predefined_values"
                                        :key="'we-checkbox-'+attribute_value.id+'-'+index">
                                        <div class="relative flex items-center "
                                            :class="{'!mt-0': index === 0}">
                                            <div class="flex items-center h-6">
                                                <input type="checkbox"
                                                    x-model="selected_attributes[attribute.slug]"
                                                    :value="attribute_value.id"
                                                    :id="'attribute-value_'+attribute_value.id"
                                                    class="form-checkbox-standard focus:ring-0">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label class="font-medium text-gray-700 cursor-pointer"
                                                    x-text="attribute_value.values"
                                                    :for="'attribute-value_'+attribute_value.id"></label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            {{-- END Dropdown --}}

                            {{-- TODO: Number  --}}

                            {{-- END Number --}}

                            {{-- TODO: Date  --}}
                            
                            {{-- END Date --}}

                          {{-- <ul class="space-y-2">
                            <li class="flex items-center">
                              <input id="apple" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Apple (56)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="microsoft" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="microsoft" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Microsoft (45)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="logitech" type="checkbox" value="" checked
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="logitech" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Logitech (97)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="sony" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="sony" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Sony (234)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="asus" type="checkbox" value="" checked
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="asus" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Asus (97)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="dell" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="dell" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Dell (56)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="msi" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="msi" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                MSI (97)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="canon" type="checkbox" value="" checked
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="canon" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Canon (49)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="benq" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="benq" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                BenQ (23)
                              </label>
                            </li>
                
                            <li class="flex items-center">
                              <input id="razor" type="checkbox" value=""
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                
                              <label for="razor" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Razor (49)
                              </label>
                            </li>
                
                            <a href="#"
                              class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">
                              View all
                            </a>
                          </ul> --}}
                        </div>
                    </div>
                </div>
            </template>
            {{-- END Attributes --}}
      
            <!-- Price -->
            {{-- <h2 id="price-heading">
              <button type="button"
                class="flex items-center justify-between w-full py-2 px-1.5 text-sm font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                data-accordion-target="#price-body" aria-expanded="true" aria-controls="price-body">
                <span>Price</span>
                <svg aria-hidden="true" data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" fill="currentColor"
                  viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z">
                  </path>
                </svg>
              </button>
            </h2>
            <div id="price-body" class="hidden" aria-labelledby="price-heading">
              <div class="flex items-center py-2 space-x-3 font-light border-b border-gray-200 dark:border-gray-600">
                <select id="price-from"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  <option disabled selected>From</option>
                  <option>$500</option>
                  <option>$2500</option>
                  <option>$5000</option>
                </select>
      
                <select id="price-to"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  <option disabled selected>To</option>
                  <option>$500</option>
                  <option>$2500</option>
                  <option>$5000</option>
                </select>
              </div>
            </div> --}}
      
            <!-- Worldwide Shipping -->
            {{-- <h2 id="worldwide-shipping-heading">
              <button type="button"
                class="flex items-center justify-between w-full py-2 px-1.5 text-sm font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                data-accordion-target="#worldwide-shipping-body" aria-expanded="true"
                aria-controls="worldwide-shipping-body">
                <span>Worldwide Shipping</span>
                <svg aria-hidden="true" data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" fill="currentColor"
                  viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z">
                  </path>
                </svg>
              </button>
            </h2>
            <div id="worldwide-shipping-body" class="hidden" aria-labelledby="worldwide-shipping-heading">
              <div class="py-2 space-y-2 font-light border-b border-gray-200 dark:border-gray-600">
                <label class="relative flex items-center cursor-pointer">
                  <input type="checkbox" value="" class="sr-only peer" name="shipping_method" checked />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                  </div>
                  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">North America</span>
                </label>
      
                <label class="relative flex items-center cursor-pointer">
                  <input type="checkbox" value="" class="sr-only peer" name="shipping_method" />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                  </div>
                  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">South America</span>
                </label>
      
                <label class="relative flex items-center cursor-pointer">
                  <input type="checkbox" value="" class="sr-only peer" name="shipping_method" />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                  </div>
                  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Asia</span>
                </label>
      
                <label class="relative flex items-center cursor-pointer">
                  <input type="checkbox" value="" class="sr-only peer" name="shipping_method" checked />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                  </div>
                  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Australia</span>
                </label>
      
                <label class="relative flex items-center cursor-pointer">
                  <input type="checkbox" value="" class="sr-only peer" name="shipping_method" />
                  <div
                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                  </div>
                  <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Europe</span>
                </label>
              </div>
            </div> --}}
      
            <!-- Rating -->
            {{-- <h2 id="rating-heading">
              <button type="button"
                class="flex items-center justify-between w-full py-2 px-1.5 text-sm font-medium text-left text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700"
                data-accordion-target="#rating-body" aria-expanded="true" aria-controls="rating-body">
                <span>Rating</span>
                <svg aria-hidden="true" data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" fill="currentColor"
                  viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z">
                  </path>
                </svg>
              </button>
            </h2>
            <div id="rating-body" class="hidden" aria-labelledby="rating-heading">
              <div class="py-2 space-y-2 font-light border-b border-gray-200 dark:border-gray-600">
                <div class="flex items-center">
                  <input id="five-stars" type="radio" value="" name="rating"
                    class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                  <label for="five-stars" class="flex items-center ml-2">
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>First star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Second star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Third star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Fourth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Fifth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                  </label>
                </div>
      
                <div class="flex items-center">
                  <input id="four-stars" type="radio" value="" name="rating"
                    class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                  <label for="four-stars" class="flex items-center ml-2">
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>First star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Second star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Third star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Fourth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fifth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                  </label>
                </div>
      
                <div class="flex items-center">
                  <input id="three-stars" type="radio" value="" name="rating" checked
                    class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                  <label for="three-stars" class="flex items-center ml-2">
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>First star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Second star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Third star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fourth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fifth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                  </label>
                </div>
      
                <div class="flex items-center">
                  <input id="two-stars" type="radio" value="" name="rating"
                    class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                  <label for="two-stars" class="flex items-center ml-2">
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>First star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>Second star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Third star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fourth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fifth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                  </label>
                </div>
      
                <div class="flex items-center">
                  <input id="one-star" type="radio" value="" name="rating"
                    class="w-4 h-4 bg-gray-100 border-gray-300 text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                  <label for="one-star" class="flex items-center ml-2">
                    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <title>First star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Second star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Third star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fourth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor"
                      viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Fifth star</title>
                      <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                      </path>
                    </svg>
                  </label>
                </div>
              </div>
            </div> --}}
        </div>
    </div>

    <div class="w-full btn-primary pb-2 mb-2 text-base font-semibold text-gray-900 px-2 pt-2 mt-2 cursor-pointer" @click="$wire.filter();">
        {{ translate('Filter') }}
    </div>
</div>