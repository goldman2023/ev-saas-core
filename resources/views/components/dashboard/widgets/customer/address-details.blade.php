<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-3 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="w-full">
                <h4 class="font-semibold">{{ translate('Billing Address') }}</h4>
            </div>
        </div>
    </div>
    <div class="px-3 py-3 sm:px-3">
        <div>
            <span>{{ translate('Type')}}: </span>
            {{ $user->entity }}
        </div>
        <div>
            <span>{{ translate('Country')}}: </span>
            {{ $user->getUserMeta('address_country') }}
        </div>

        <div>
            <span>{{ translate('City')}}: </span>
            {{ $user->getUserMeta('address_city') }}
        </div>
        <div>
            <span>{{ translate('Address')}}: </span>
            {{ $user->getUserMeta('address_line') }}
        </div>
        @if($user->getUserMeta('address_state'))
        <div>
            <span>{{ translate('State')}}: </span>
            {{ $user->getUserMeta('address_state') }}
        </div>
        @endif

        @if($user->getUserMeta('address_postal_code'))
        <div>
            <span>{{ translate('Postal Code')}}: </span>
            {{ $user->getUserMeta('address_postal_code') }}
        </div>
        @endif

        @if($user->getUserMeta('company_name'))
        <div>
            <span>{{ translate('Company Name')}}: </span>
            {{ $user->getUserMeta('company_name') }}
        </div>
        @endif

        @if($user->getUserMeta('company_vat'))

        <div>
            <span>{{ translate('Company VAT')}}: </span>
            {{ $user->getUserMeta('company_vat') }}
        </div>
        @endif

        @if($user->getUserMeta('company_vat'))

        <div>
            <span>{{ translate('Company Number')}}: </span>
            {{ $user->getUserMeta('company_registration_number') }}
        </div>
        @endif

    </div>
</div>
