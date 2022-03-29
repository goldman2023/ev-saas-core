<div id="cometchat">
</div>
<script defer src="https://widget-js.cometchat.io/v3/cometchatwidget.js"></script>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        var authKey = '1ae443addff490b0ac837b5b229b7e7cb945364f';
		CometChatWidget.init({
            "widgetID" : "2c7f9f3c-bf64-45df-ba75-649038e001fd",
			"appID": "2062192784f94713",
			"appRegion": "eu",
			"authKey": authKey,
		}).then(response => {
  /**
   * Create user once initialization is successful
   */
        const user = new CometChatWidget.CometChat.User("web_{{ Auth::user()->id }}");
        user.setName("{{ Auth::user()->name }}");
        // user.setAvatar('#');
        // user.setLink({{ Auth::user()->id }});
        CometChatWidget.createOrUpdateUser(user).then((user) => {
            console.log(user);
       // Proceed with user login
        CometChatWidget.login({
        uid: "web_{{ Auth::user()->id }}",
        }).then((loggedInUser) => {

      // Proceed with launching your Chat Widget
            CometChatWidget.launch({
            "widgetID" : "2c7f9f3c-bf64-45df-ba75-649038e001fd",
			"appID": "2062192784f94713",
			"appRegion": "eu",
			"authKey": authKey,
            "docked": "false",
            "alignment": "right", //left or right
            "target": "#cometchat",
            "roundedCorners": "false",
            "height": "80vh",
            "width": "100%",
            "defaultType": 'user' //user or group

		})
            });
        });


        });
	});
</script>
