<div id="cometChatWidget">
</div>
<script defer src="https://widget-js.cometchat.io/v3/cometchatwidget.js"></script>

<script>

    window.addEventListener('DOMContentLoaded', (event) => {
		CometChatWidget.init({
			"appID": "19844836fbbe443a",
			"appRegion": "eu",
			"authKey": "3ae679e7ea038faed86dc55249df79213d4c262f"
		}).then(response => {
			console.log("Initialization completed successfully");
			//You can now call login function.
			CometChatWidget.login({
				"uid": "superhero1"
			}).then(response => {
				CometChatWidget.launch({
					"widgetID": "e0f6177f-7236-4982-8b49-d514b681fdff",
                    "docked": "true",
					"target": "#cometChatWidget",
					"roundedCorners": "true",
					"height": "450px",
					"width": "400px",
					"defaultID": 'superhero1', //default UID (user) or GUID (group) to show,
					"defaultType": 'user' //user or group
				});
			}, error => {
				console.log("User login failed with error:", error);
				//Check the reason for error and take appropriate action.
			});
		}, error => {
			console.log("Initialization failed with error:", error);
			//Check the reason for error and take appropriate action.
		});
	});
</script>
