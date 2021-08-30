<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Forms' path
    |--------------------------------------------------------------------------
    |
    | Namespace where form classes can be found.
    |
    */
    'path' => 'App\\Forms',

    /*
    |--------------------------------------------------------------------------
    | Vue component
    |--------------------------------------------------------------------------
    |
    | Default Vue component.
    |
    */
    'component' => 'laraform',

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    |
    | Default location to store uploaded files.
    |
    */
    'store' => [
        'disk' => 'public',
        'folder' => 'files',
    ],

    /*
    |--------------------------------------------------------------------------
    | Trix store
    |--------------------------------------------------------------------------
    |
    | Default location to store files uploaded via Trix.
    |
    */
    'trix' => [
        'disk' => 'public',
        'folder' => 'media',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate limit
    |--------------------------------------------------------------------------
    |
    | Rate limit for `unique` and `exists` validator rules.
    |
    */
    'throttle' => '60,1',

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | Default theme.
    |
    */
    'theme' => 'bs4',

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | Default form layout. If `false` no layout will be used.
    |
    */
    'layout' => false,

    /*
    |--------------------------------------------------------------------------
    | Labels
    |--------------------------------------------------------------------------
    |
    | Determines if the elements which do not have a `label` option defined
    | should have a label DOM element rendered.
    |
    */
    'labels' => false,

    /*
    |--------------------------------------------------------------------------
    | Form Errors
    |--------------------------------------------------------------------------
    |
    | Determines if errors should be displayed above form.
    |
    */
    'formErrors' => true,

    /*
    |--------------------------------------------------------------------------
    | Form Steps
    |--------------------------------------------------------------------------
    |
    | Determines whether form steps should be enabled/completed when loading data.
    |
    */
    'enableStepsOnLoad' => true,

    'completeStepsOnLoad' => true,

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    |
    | Default column settings.
    |
    */
    'columns' => [
        'element' => 12,
        'label' => 12,
        'field' => 12,
    ],

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    |
    | Available languages for translatable elements.
    |
     */
    'languages' => [
        'en' => [
            'code' => 'en',
            'label' => 'English'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    |
    | Default language for multilingual forms.
    |
    */
    'language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Default translator
    |--------------------------------------------------------------------------
    |
    | The default translator class to be used when using multilingual elements
    |
    */
    'translator' => Laraform\Translator\Json::class,

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Default locale.
    |
    */
    'locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | App timezone
    |--------------------------------------------------------------------------
    |
    | Timezone of the application.
    |
    */
    'timezone' => null,

    /*
    |--------------------------------------------------------------------------
    | User timezone
    |--------------------------------------------------------------------------
    |
    | Forced timezone of the user. Only define it if you are 100% sure that
    | your users will be from this timezone.
    |
    */
    'userTimezone' => null,

    /*
    |--------------------------------------------------------------------------
    | Validate On
    |--------------------------------------------------------------------------
    |
    | When user inputs should be validated.
    |
    | Possible values:
    |   submit: upon form submission
    |   change: instantly upon user input
    |   step: before moving to the next step when using Wizard
    |
    */
    'validateOn' => 'submit|change|step',

    /*
    |--------------------------------------------------------------------------
    | Endpoint
    |--------------------------------------------------------------------------
    |
    | Default endpoint where the form should submit.
    |
    */
    'endpoint' => '/laraform/process',

    /*
    |--------------------------------------------------------------------------
    | Method
    |--------------------------------------------------------------------------
    |
    | Default method how the form should be submitted.
    |
    */
    'method' => 'POST',

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    |
    | A list of custom elements to be added to Laraform.
    |
    | eg. [
    |  'custom' => App\Elements\CustomElement::class,
    | ]
    |
    */
    'elements' => [],
];
