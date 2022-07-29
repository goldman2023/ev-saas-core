@component('mail::message')
 
# {{ translate('Your trial has started!') }}
{{ translate('Your trial has officially started. Thank you for trying our services!') }}
<br>
{{ translate('Trial will end on: ').$subscription->end_date->format('d M, Y') }}
<br>
<br>
{{ translate('After trial period ends, you will be charged automatically. If you don\'t want to continue using our services, please cancel the subscription before trial ends!!') }}

@component('mail::button', ['url' => route('my.plans.management')])
    {{ translate('View details') }}
@endcomponent

{{ translate('Regards') }},<br>
{{ get_tenant_setting('site_name') }}
@endcomponent