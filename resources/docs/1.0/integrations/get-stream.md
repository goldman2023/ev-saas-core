# Get Stream

Following packages are used in this package:
https://getstream.io/activity-feeds/
https://github.com/GetStream/stream-laravel
https://github.com/GetStream/stream-chat-react

## Structure

There is 2 parts for this, frontend and backend.

###Frontend
On frontend you can find all resources inside:
`resources/js/react/`



###Backend

Main controller to perform actions with GetStream integration:
`app/http/controllers/integrations/GetStreamController.php`


Example model to record activity items:
`app/Blog.php`