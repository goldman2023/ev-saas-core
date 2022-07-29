@component('mail::message')
 
@if($old_status === 'trial' && $new_status === 'active')
    # {{ translate('Your subscription is now fully active!') }}
    {{ translate('Trial subscription has expired. Your subscription is now fully active!') }}
@elseif($old_status === 'active' && $new_status === 'inactive') 
    # {{ translate('Your subscription is canceled!') }}
    {{ translate('Subscription has been canceled. We are sorry to see you leave.') }}
@elseif($old_status === 'active' && $new_status === 'active_until_end') {
    # {{ translate('Your subscription will be canceled on: ').$subscription->end_date->format('d M, Y') }}
@endif
 
@component('mail::button', ['url' => route('my.plans.management')])
    {{ translate('View details') }}
@endcomponent

{{ translate('Regards') }},<br>
{{ get_tenant_setting('site_name') }}
@endcomponent