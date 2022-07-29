@component('mail::message')
 
# {{ translate('Your subscription has been successfully extended!') }}
{{ translate('Subscription will expire on: ').$subscription->end_date->format('d M, Y') }}

@component('mail::button', ['url' => route('my.plans.management')])
    {{ translate('View details') }}
@endcomponent

{{ translate('Regards') }},<br>
{{ get_tenant_setting('site_name') }}
@endcomponent