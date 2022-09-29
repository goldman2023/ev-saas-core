@auth
    <!-- OpenReplay Tracking Code for Authentificated Users -->
    <script>
        var initOpts = {
        /* TODO: Make this enable/disable + add your own projectKey */
        projectKey: "ZJVbvFt4e8hleou7Nmjh",
        defaultInputMode: 2,
        __DISABLE_SECURE_MODE:true,
        obscureTextNumbers: false,
        obscureTextEmails: true,
        };

        @auth
            var startOpts = { userID: "{{ auth()->user()->email }}" };
        @else
            var startOpts = { userID: "guest" };
        @endauth
        (function(A,s,a,y,e,r){
        r=window.OpenReplay=[e,r,y,[s-1, e]];
        s=document.createElement('script');s.src=A;s.async=!a;
        document.getElementsByTagName('head')[0].appendChild(s);
        r.start=function(v){r.push([0])};
        r.stop=function(v){r.push([1])};
        r.setUserID=function(id){r.push([2,id])};
        r.setUserAnonymousID=function(id){r.push([3,id])};
        r.setMetadata=function(k,v){r.push([4,k,v])};
        r.event=function(k,p,i){r.push([5,k,p,i])};
        r.issue=function(k,p){r.push([6,k,p])};
        r.isActive=function(){return false};
        r.getSessionToken=function(){};
        })("//static.openreplay.com/latest/openreplay.js",1,0,initOpts,startOpts);
    </script>
@endauth
