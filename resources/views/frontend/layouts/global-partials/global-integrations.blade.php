{{-- Facebook App Integration --}}
@if(!empty(get_setting('facebook_app_id')) && !empty(get_setting('facebook_app_secret')))
<script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{{ get_setting('facebook_app_id') }}',
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