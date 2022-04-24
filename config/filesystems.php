<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 's3'),

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => public_path(),
            'throw' => false,
        ],

        'backup-local' => [
            'driver' => 'local',
            'root' => storage_path('logs'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('DIGITALOCEAN_SPACES_KEY'),
            'secret' => env('DIGITALOCEAN_SPACES_SECRET'),
            'region' => env('DIGITALOCEAN_SPACES_REGION'),
            'bucket' => env('DIGITALOCEAN_SPACES_BUCKET'),
            'url' => env('DIGITALOCEAN_SPACES_SUBDOMAIN_ENDPOINT'),
            'endpoint' => env('DIGITALOCEAN_SPACES_SUBDOMAIN_ENDPOINT'),
            'subdomain_endpoint' => env('DIGITALOCEAN_SPACES_SUBDOMAIN_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    'disk_types' => [
        'local' => ['local', 'public', 'backup-local'],
        'cloud' => ['s3', 'google'],
        'remote_plain' => [], // This is for 'sftp', 'ftp' etc.
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
