<?php

return [

    /*
    |-----------------------------------------------------------------------------
    | Your GetStream.io API credentials (you can them from getstream.io/dashboard)
    |-----------------------------------------------------------------------------
    |
    */

    'api_key' => '9j8mussvhwku',
    'api_secret' => 'k3hbcktzjskde4nenef9kvpud23rh6vbza6gzuc3s8spcv37h6aybkuv4z6ft3zd',
    'api_app_id' => '111762',
    /*
    |-----------------------------------------------------------------------------
    | Client connection options
    |-----------------------------------------------------------------------------
    |
    */
    'location' => 'us-east',
    'timeout' => 3,
    /*
    |-----------------------------------------------------------------------------
    | The default feed manager class
    |-----------------------------------------------------------------------------
    |
    */

    'feed_manager_class' => 'GetStream\StreamLaravel\StreamLaravelManager',

    /*
    |-----------------------------------------------------------------------------
    | The feed that keeps content created by its author
    |-----------------------------------------------------------------------------
    |
    */
    'user_feed' => 'user',
    /*
    |-----------------------------------------------------------------------------
    | The feed containing notification activities
    |-----------------------------------------------------------------------------
    |
    */
    'notification_feed' => 'notification',
    /*
    |-----------------------------------------------------------------------------
    | The feeds that shows activities from followed user feeds
    |-----------------------------------------------------------------------------
    |
    */
    'news_feeds' => [
        'timeline' => 'timeline',
        'timeline_aggregated' => 'timeline_aggregated',
    ]
];
