@component('mail::message')
# @lang('Subscription updated')
 
@lang('Your subscription has been updated. Please check your new subscription details by clicking the button below.')
 
@component('mail::button', ['url' => route('my.plans.management')])
@lang('View details')
@endcomponent

@lang('Regards'),<br>
{{ get_tenant_setting('site_name') }}
@endcomponent