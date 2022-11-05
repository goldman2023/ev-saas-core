<div class="w-full" x-data="{
    current: 0,
    educations: [],
    item_template: {
        'school': 'School/Institution...',
        'degree_title': 'Degree title...',
        'field_of_study': '',
        'certificates': [{}],
        'start_date': '',
        'end_date': '',
        'description': '',
    },
    add() {
        if(this.educations === undefined || this.educations === null) {
            this.educations = [ {...this.item_template} ];
        } else {
            this.educations.push({...this.item_template});
        }

        this.current = this.educations.length - 1;
        $dispatch('display-modal', {'id': 'work-education-modal'});
    },
    remove(index) {
        this.current = 0;
        this.educations.splice(index, 1);

        $wire.set('{{ $field }}', this.educations.filter(function(x){return x}), true);
        $wire.saveEducation();
    }
}"
    x-init="if({{ $field }} === undefined || {{ $field }} === null) {
        experiences = [];
    } else {
        experiences = {{ $field }};
    }">
    <ul class="border-b border-gray-200 divide-y divide-gray-200" x-show="educations != null && educations.length > 0">
        <template x-for="(item, index) in educations">
            <li class="py-4 flex items-center justify-between space-x-3">
                <div class="min-w-0 flex-1 flex items-center space-x-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate" x-text="item.school+' ('+item.field_of_study+')'"></p>
                        <p class="text-sm font-medium text-gray-500 truncate" x-text="item.degree_title"></p>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" @click="current = index; $dispatch('display-modal', {'id': 'work-education-modal'})" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        @svg('heroicon-s-pencil', ['class' => '-ml-1 mr-0.5 h-5 w-5 text-gray-400'])
                        <span class="text-sm font-medium text-gray-900">{{ translate('Edit') }}</span>
                    </button>
                </div>
            </li>
        </template>
    </ul>

    <div class="btn-ghost !pl-0 !text-14 mt-1" @click="add()">
        @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
        {{ translate('Add new') }}
    </div>

    <x-system.form-modal id="work-education-modal" title="Education" :prevent-close="true">
        <!-- Education School -->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('School/Institution') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="educations[current].school" :x="true"/>
            </div>
        </div>
        <!-- END Education School -->

        <!-- Education Degree title-->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Degree title') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="educations[current].degree_title" :x="true" />
            </div>
        </div>
        <!-- END Education Degree title  -->

        <!-- Education Field of study-->
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Field of study') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input field="educations[current].field_of_study" :x="true" />
            </div>
        </div>
        <!-- END Education Field of study  -->

        {{-- Start/End date --}}
        <div class="grid grid-cols-2 gap-6 mb-3">
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('Start') }}
                </label>
                <x-dashboard.form.date id="workplace-start-date" field="educations[current].start_date"></x-dashboard.form.date>
            </div>
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-900 mb-2">
                    {{ translate('End') }}
                </label>
                <x-dashboard.form.date id="workplace-end-date" field="educations[current].end_date"></x-dashboard.form.date>
            </div>
        </div>
        {{-- END Start/End date --}}

        {{-- Description --}}
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Description') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <textarea x-model="educations[current].description" rows="3" class="max-w-lg shadow-sm block w-full focus:ring-primary focus:border-primary sm:text-sm border border-gray-300 rounded-md"></textarea>
            </div>
        </div>
        {{-- END Description --}}

        {{-- Certificates --}}
        <div class="flex flex-col mb-3" x-data="{}">
            <label class="block text-sm font-medium text-gray-900 mb-2">
                {{ translate('Certificates') }}
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.file-selector field="educations[current].certificates[0]" id="education-files" template="simple" selected-image="educations[current].certificates"></x-dashboard.form.file-selector>

            </div>
        </div>
        {{-- END Certificates --}}



        <div class="w-full flex justify-between mt-4 pt-3 border-t border-gray-200" x-data="{}">
            <button type="button" class="" @click="remove(current); show = false;">
                @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-danger'])
            </button>

            <div class="">
                <button type="button" @click="show = false" class="btn btn-ghost btn-sm mr-3">
                    {{ translate('Close') }}
                </button>
                <button type="button" class="btn btn-primary btn-sm" @click="
                    $wire.set('{{ $field }}', educations, true);
                    show = false;
                " wire:click="saveEducation()">
                    {{ translate('Save') }}
                </button>
            </div>
        </div>
    </x-system.form-modal>
</div>
