{{-- Google Analytics Integration --}}
@if(get_tenant_setting('google_analytics_enabled') && !empty($gtag = get_tenant_setting('gtag_id')))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtag }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $gtag }}');
</script>
@endif
{{-- Google Analytics Integration --}}

{{-- Facebook App Integration --}}
@if(!empty(get_tenant_setting('facebook_app_id')) && !empty(get_tenant_setting('facebook_app_secret')))
<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{{ get_tenant_setting('facebook_app_id') }}',
        cookie     : true,
        xfbml      : true,
        version    : 'v13.0'
      });
        
      FB.AppEvents.logPageView();   
    };
  
    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "https://connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
</script>
@endif
{{-- END Facebook App Integration --}}