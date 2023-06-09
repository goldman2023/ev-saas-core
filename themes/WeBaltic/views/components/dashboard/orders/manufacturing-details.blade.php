<div  class="bg-white">
<div>
    <h3 class="text-lg font-medium leading-6 text-gray-900">
        {{ translate('Manufacturing details') }}
    </h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">
        {{ translate('Enter manufacturing details') }}
    </p>
</div>
<div class="mt-5 border-t border-gray-200">
    <dl class="divide-y divide-gray-200">
        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>{{ translate('Assembly Notes') }}</span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" :label="translate('Assembly Notes')" key="assembly_notes" type="string" form_type='textarea'></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>{{ translate('Assembler') }}</span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Assembler" key="assembler"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Date of Manufacturing (Used For Certificate)') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field
                    :subject="$order"
                    label="Date of Manufacturing"
                    type="date"
                    form-type="date"
                    key="cycle_step_date_manufacturing"
                    :custom-properties="['range' => false, 'with_time' => false]"></x-wef.field>
            </dd>
        </div>


        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Date of Assembly') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field
                    :subject="$order"
                    label="Date of Assembly"
                    type="date"
                    form-type="date"
                    key="cycle_step_date_assembly"
                    :custom-properties="['range' => false, 'with_time' => true]"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Date of Welding') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Date of Welding" type="date" form_type="date" key="cycle_step_date_welding"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Date of Inspection') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Date of Inspection" type="date" form_type="date" key="date_of_inspection"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Inspected by') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Inspected by" type="string" form_type="plain_text" key="inspected_by"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Inspection notes') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Inspection Notes" type="string" form_type="textarea" key="inspection_notes"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Serial Number') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Serial Number (Custom)" type="string" form_type="plain_text" key="serial_number_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Pakabos vieta') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Pakabos vieta" type="string" form_type="plain_text" key="pakabos_vieta_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Brėžinių skaičius') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Brėžinių skaičius" type="string" form_type="plain_text" key="breziniu_skaicius_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Axle make') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="Axle make" type="string" form_type="plain_text" key="axle_make_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Wheels') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="{{ translate('Wheels') }}" type="string" form_type="plain_text" key="wheels_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Lights') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="{{ translate('Lights') }}" type="string" form_type="plain_text" key="lights_custom"></x-wef.field>
            </dd>
        </div>

        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
            <dt class="text-sm font-medium text-gray-500">
                <span>
                    {{ translate('Coupling') }}
                </span>
            </dt>
            <dd class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                <x-wef.field :subject="$order" label="{{ translate('Coupling') }}" type="string" form_type="plain_text" key="lights_custom"></x-wef.field>
            </dd>
        </div>


    </dl>
</div>
</div>
