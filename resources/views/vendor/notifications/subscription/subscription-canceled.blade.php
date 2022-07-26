@component('mail::message')
# @lang('Subscription canceled')
 
@lang('Your subscription has been canceled. We are sorry to see you off.')
 
@lang('Regards'),<br>
{{ get_tenant_setting('site_name') }}
@endcomponent