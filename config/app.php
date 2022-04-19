<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'EV-SaaS'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),
    'debug_bar' => env('DEBUGBAR_ENABLED', true),

    'debug_blacklist' => [
        '_ENV' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET',
        ],
        '_SERVER' => [
            'APP_KEY',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET',
        ],
        '_POST' => [
            'password',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'https://we-saas.com'),

    /*
    |--------------------------------------------------------------------------
    | FORCE HTTPS
    |--------------------------------------------------------------------------
    |
    | Wheter to force using secure connection.
    | This should be always true on production.
    | While local development depends on setup and configuration.
    |
    */

    'force_https' => env('FORCE_HTTPS', true),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('DEFAULT_LANGUAGE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
        App\Providers\SocialiteServiceProvider::class,
        niklasravnsborg\LaravelPdf\PdfServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        \Laravel\Passport\PassportServiceProvider::class,
        \Spatie\Activitylog\ActivitylogServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        /*
         * Package Service Providers...
         */
        \App\Providers\GoogleDriveServiceProvider::class,
        Bkwld\Cloner\ServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        // App\Providers\SparkServiceProvider::class,
       // App\Providers\NovaServiceProvider::class,
       App\Providers\NovaServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Stancl\Tenancy\TenancyServiceProvider::class,
        App\Providers\TenancyServiceProvider::class, // <-- here
        Laravel\Passport\PassportServiceProvider::class,
        Barryvdh\Snappy\ServiceProvider::class,

        Mews\Purifier\PurifierServiceProvider::class,

        // EVServiceProviders
        App\Providers\EVServiceProvider::class,
        App\Providers\MacrosServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\PaymentsProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'EVBaseModel' => App\Models\EVBaseModel::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Str' => Illuminate\Support\Str::class,
        'Stringy' => App\Support\Stringy::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'DataTables' => Yajra\DataTables\Facades\DataTables::class,
        'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class,
        'WeBuilder' => App\Facades\WeBuilder::class,
        'Permissions' => App\Facades\Permissions::class,
        'MyShop' => App\Facades\MyShop::class,
        'Vendor' => App\Facades\Vendor::class,
        'MediaService' => App\Facades\Media::class,
        'EVS' => App\Facades\EVS::class,
        'CartService' => App\Facades\CartService::class,
        'TenantSettings' => App\Facades\TenantSettings::class,
        'Payments' => App\Facades\Payments::class,
        'FX' => App\Facades\FX::class,
        'IMG' => App\Facades\IMG::class,
        'Countries' => App\Facades\Countries::class,
        'Categories' => App\Facades\Categories::class,
        'AttributesService' => App\Facades\AttributesService::class,
        'Theme' => Qirolab\Theme\Theme::class,
        'Purifier' => Mews\Purifier\Facades\Purifier::class,
        'Carbon' => Illuminate\Support\Carbon::class,
        'UUID' => Webpatser\Uuid\Uuid::class,
        'StripeService' => App\Facades\StripeService::class,
    ],

];
