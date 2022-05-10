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

{{-- Google Tags Manager Integration --}}
@if(get_tenant_setting('google_tag_manager_enabled') && !empty($gtm = get_tenant_setting('google_tag_manager_id')))
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','{{ $gtm }}');</script>
@endif
{{-- Google Tags Manager Integration --}}

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

<!-- Meta Pixel Code -->
@fbpix()
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{{ get_tenant_setting('facebook_pixel_id') }}');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ get_tenant_setting('facebook_pixel_id') }}&ev=PageView&noscript=1"
/></noscript>
@endfbpix
<!-- END Meta Pixel Code -->

{{-- TODO: Move this only to public facing forms! --}}
{{-- Google Recaptcha v3 --}}
@recaptcha
  <script src="https://www.google.com/recaptcha/api.js?render={{ get_tenant_setting('google_recaptcha_site_key') }}"></script>
@endrecaptcha
{{-- END Google Recaptcha v3 --}}
