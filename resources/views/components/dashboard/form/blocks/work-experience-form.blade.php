<div class="w-full" x-data="{
    current: 0,
    experiences: {{ $field }},
    item_template: {
        'title': 'Example',
        'company_name': 'Example',
        'employment_type': '',
        'location': '',
        'currently_working_there': '',
        'start_date': '',
        'end_date': '',
        'description': '',
    },
    add() {
        if(this.experiences === undefined || this.experiences === null) { 
            this.experiences = [ {...this.item_template} ]; 
        } else {
            this.experiences.push({...this.item_template});
        }
    },
    remove(index) {
        this.current = 0;
        this.experiences.splice(index, 1);

        $wire.set('{{ $field }}', this.experiences.filter(function(x){return x}), true);
        $wire.saveWorkExperience();
    }
}" x-init="if(experiences === undefined || experiences === null) { 
    experiences = [  ]; 
}">
    {{-- <template x-if="_.get('{{ $field }}', []) != null && _.get('{{ $field }}', []).length > 0"> --}}
        <ul class="mt-4 border-b border-gray-200 divide-y divide-gray-200">
            <template x-for="(item, index) in experiences">
                <li class="py-4 flex items-center justify-between space-x-3">
                    <div class="min-w-0 flex-1 flex items-center space-x-3">
                      {{-- <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                      </div> --}}
                      <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate" x-text="item.company_name+' ('+item.location+')'"></p>
                        <p class="text-sm font-medium text-gray-500 truncate" x-text="item.title"></p>
                      </div>
                    </div>
                    <div class="flex-shrink-0">
                      <button type="button" @click="current = index; $dispatch('display-modal', {'id': 'work-experience-modal'})" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        @svg('heroicon-s-pencil', ['class' => '-ml-1 mr-0.5 h-5 w-5 text-gray-400'])
                        <span class="text-sm font-medium text-gray-900">{{ translate('Edit') }}</span>
                      </button>
                    </div>
                </li>
            </template>
        </ul>
    {{-- </template> --}}

    <div class="btn-ghost !pl-0 !text-14 mt-1" @click="add()">
        @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
        {{ translate('Add new') }}
    </div>

    <x-system.form-modal id="work-experience-modal" title="Work Experience" :prevent-close="true">
        <!-- Workplace Title -->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Title/Position') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="experiences[current].title" :x="true"/>
            </div>
        </div>
        <!-- END Workplace Title -->

        <!-- Workplace Company name -->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Company name') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="experiences[current].company_name" :x="true" />
            </div>
        </div>
        <!-- END Workplace Employment type  -->

        <!-- Workplace Employment type -->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Employment type') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.select field="experiences[current].employment_type" :items="\App\Enums\EmploymentTypeEnum::labels()" selected="experiences[current].employment_type" :nullable="false"></x-dashboard.form.select>
            </div>
        </div>
        <!-- END Workplace Employment type  -->

        <!-- Workplace Location -->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Location') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="experiences[current].location" :x="true" />
            </div>
        </div>
        <!-- END Workplace Location  -->

        {{-- Start/End date --}}
        <div class="grid grid-cols-2 gap-6 mb-3">
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('Start') }}
                </label>
                <x-dashboard.form.date id="workplace-start-date" field="experiences[current].start_date"></x-dashboard.form.date>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('End') }}
                </label>
                <x-dashboard.form.date id="workplace-end-date" field="experiences[current].end_date"></x-dashboard.form.date>
            </div>
        </div>
        {{-- END Start/End date --}}

        {{-- Currently working there? --}}
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Currently working there?') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.toggle field="experiences[current].currently_working_there" />
            </div>
        </div>
        {{-- END Currently working there? --}}

        {{-- Description --}}
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Description') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <textarea x-model="experiences[current].description" rows="3" class="max-w-lg shadow-sm block w-full focus:ring-primary focus:border-primary sm:text-sm border border-gray-300 rounded-md"></textarea>
            </div>
        </div>
        {{-- END Description --}}

        <div class="w-full flex justify-between mt-4 pt-3 border-t border-gray-200" x-data="{}">
            <button type="button" class="" @click="remove(current); show = false;">
                @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-danger'])
            </button>

            <div class="">
                <button type="button" @click="show = false" class="btn btn-ghost btn-sm mr-3">
                    {{ translate('Close') }}
                </button>
                <button type="button" class="btn btn-primary btn-sm" @click="
                    $wire.set('{{ $field }}', experiences, true);
                    show = false;
                " wire:click="saveWorkExperience()">
                    {{ translate('Save') }}
                </button>
            </div>
        </div>
    </x-system.form-modal>
</div>