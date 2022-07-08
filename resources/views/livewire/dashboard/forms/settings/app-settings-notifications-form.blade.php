<div class="w-full" x-data="{
  settings: @js($settings),
}" x-init="" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>

<div class="w-full relative">
  <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden">
  </x-ev.loaders.spinner>

  <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">

      <div class="grid grid-cols-12 gap-8 mb-10">
          <div class="col-span-12">

              <div class="p-0 border bg-white border-gray-200 rounded-lg shadow">

                  <div class="w-full mb-5">

                      {{-- Notifications --}}
                      <div class="w-full px-5">
                          <div class="flex flex-col" x-data="{
                              all_notifications_list: @js(TenantSettings::settingsDataTypes()['system_notifications_list']),
                              notification_setting_template: {
                                'enabled': false,
                                'to_causer': false,
                                'to_admin': false,
                                'via': [],
                              },
                              toggleProperty(key, property) {
                                  if(_.get(settings.system_notifications_list, key+'.'+property, null) === null) {
                                      _.set(settings.system_notifications_list, key+'.'+property, false); // if it doesn't exist, set it!
                                  }
                                

                                  if(_.get(settings.system_notifications_list, key+'.'+property, null) === false) {
                                      _.set(settings.system_notifications_list, key+'.'+property, true);
                                  } else {
                                      _.set(settings.system_notifications_list, key+'.'+property, false);
                                  }
                              },
                              initFields() {
                                if(settings.system_notifications_list == null || settings.system_notifications_list == undefined) {
                                    settings.system_notifications_list = {};
                                }
                                
                                for (const key in this.all_notifications_list) {
                                  console.log(settings.system_notifications_list.hasOwnProperty(key));

                                  if(!settings.system_notifications_list.hasOwnProperty(key) || 
                                      !(typeof settings.system_notifications_list[key] === 'object' &&
                                        !Array.isArray(settings.system_notifications_list[key]) &&
                                        settings.system_notifications_list[key] !== null)
                                    ) {
                                    settings.system_notifications_list[key] = {...this.notification_setting_template};
                                  }
                                }

                                console.log(settings.system_notifications_list);
                              },
                          }" x-init="initFields()">
                              <div class="flex flex-col py-3">
                                  <div class="mt-0 flex flex-col">
                                    <div class="overflow-x-auto ">
                                        <div class="inline-block min-w-full py-2 px-1 align-middle">
                                            <div class="shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-300">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-1 px-3 text-left text-sm font-semibold text-gray-900">
                                                                {{ translate('Notification') }}</th>
                                                            <th scope="col"
                                                                class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                {{ translate('Enabled') }}</th>
                                                            <th scope="col"
                                                                class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                {{ translate('To Causer') }}</th>
                                                            <th scope="col"
                                                                class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                {{ translate('To Admin') }}</th>
                                                            <th scope="col"
                                                                class="px-1 py-1 text-center text-sm font-semibold text-gray-900">
                                                                {{ translate('Via Channels') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                        <template x-for="(notif_definition, notif_key) in all_notifications_list">
                                                            <tr x-data="{
                                                              get enabled() { return _.get(settings.system_notifications_list, notif_key+'.enabled', false) },
                                                              get to_causer() { return _.get(settings.system_notifications_list, notif_key+'.to_causer', false) },
                                                              get to_admin() { return _.get(settings.system_notifications_list, notif_key+'.to_admin', false) },
                                                              get via() { return _.get(settings.system_notifications_list, notif_key+'.via', []) },
                                                            }">
                                                                <td class="whitespace-nowrap py-2 px-3 text-14 font-medium text-gray-900 "
                                                                    x-text="notif_key"></td>
                                                                <td
                                                                    class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                    <button type="button"
                                                                        @click="toggleProperty(notif_key, 'enabled')"
                                                                        :class="{'bg-primary': enabled, 'bg-gray-200': !enabled}"
                                                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                        role="switch">
                                                                        <span
                                                                            :class="{'translate-x-5': enabled, 'translate-x-0': !enabled}"
                                                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                    </button>
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                    <button type="button"
                                                                        @click="toggleProperty(notif_key, 'to_causer')"
                                                                        x-show="enabled"
                                                                        :class="{'bg-primary': to_causer , 'bg-gray-200': !to_causer}"
                                                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                        role="switch">
                                                                        <span
                                                                            :class="{'translate-x-5': to_causer, 'translate-x-0': !to_causer}"
                                                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                    </button>
                                                                </td>
                                                                <td
                                                                    class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                    <button type="button"
                                                                        @click="toggleProperty(notif_key, 'to_admin')"
                                                                        x-show="enabled"
                                                                        :class="{'bg-primary': to_admin , 'bg-gray-200': !to_admin}"
                                                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                                                        role="switch">
                                                                        <span
                                                                            :class="{'translate-x-5': to_admin, 'translate-x-0': !to_admin}"
                                                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                                                    </button>
                                                                </td>
                                                                <td class="whitespace-nowrap px-1 py-2 text-sm text-gray-500 text-center">
                                                                  {{-- <div class="w-full" x-show="enabled">
                                                                    <x-dashboard.form.select 
                                                                      field="settings.system_notifications_list[notif_key].via"
                                                                      :multiple="true"
                                                                      :items="\App\Enums\NotificationChannelsEnum::labels()" 
                                                                      selected="settings.system_notifications_list[notif_key].via" 
                                                                      :nullable="false"></x-dashboard.form.select>
                                                                  </div> --}}
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </div>

                              <div class="flex items-center">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                    $wire.set('settings.system_notifications_list', settings.system_notifications_list, true);

                                    $wire.saveAdvanced('system_notifications_list');
                                  ">
                                  {{ translate('Save') }}
                            </button>
                              </div>
                          </div>

                          
                      </div>
                      {{-- END Notifications --}}
                  </div>


              </div>
          </div>
      </div>
  </div>
</div>
