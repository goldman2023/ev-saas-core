# Frontend Guidelines

- [Frontend Guidelines](#)

Following project is based on:
* Boostrap 4



## UI Kit and Components
This project utilizes Front Dashboard and UI kit template.
There is 2 parts of this UI kit:
* [Front](https://htmlstream.com/front/index.html) - [documentation](https://htmlstream.com/front/snippets/index.html)
* [Front Dashboard](https://htmlstream.com/front-dashboard/index.html) - [documentation](https://htmlstream.com/front-dashboard/documentation/index.html)


## Styleguide:
Please check: http://new.b2bwood.com/styleguide
for general components usage and sizing/spacing/color utilities.

## Build Process:

After setting up locally we need to run:
`npm run watch` to compile assets

## Creating Components
All of the new components should be created as blade components.

**Blade Components Documentation:**
https://laravel.com/docs/8.x/blade#components

```html
<x-company-card :company="$company"></x-company-card>
```

This component should accept Company Object (Not ID!)

Most of the components should be built in a way, that we pass all the necessary data
as a single variable.

Components can have extra options like class and extra attibutes like in this example:

```html
<x-alert type="error" :message="$message" class="mb-4"/>
```

This method is particularly useful for defining a set of default CSS classes that should always be applied to a component:
Inside component template:
```html
<div {{ $attributes->merge(['class' => 'alert alert-'.$type]) }}>
    {{ $message }}
</div>
```


