[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fcd104744-469d-484a-a6a0-af45f2d1c631&style=plastic)](https://forge.laravel.com)


BusinessPress Core. This is a repository of website framework with multitenancy and SaaS Application builder.

# General Information

Documentation URL: https://docs.we-saas.com

Production url: https://businesspress.io

Staging URL: https://dev.businesspress.io

Cypress Dashboard: https://dashboard.cypress.io/projects/teqkyz/runs

Asana Board: https://app.asana.com/0/1201613541420424/list

# Features

- multi-tenancy
- multilanguage (Coming soon)
- stripe payment gateway and stripe checkout option
- scheduling
- email templates
- email notifications

## Documentation
Documentation can be found at: https://docs.we-saas.com/

## Demo
https://demo.businesspress.io

## Remote Development Environment
https://app.gitbook.com/o/2dee19VQhhAOUjO27T0L/s/3mdkYoieCX8rouQqo60o/

## Local setup
-   After checking out project from git
-   Edit your `.env`
-   run `php artisan migrate --path=/database/migrations/central`
-   run `php artisan migrate --path=/database/migrations/tenant`
-   run `php artisan serve` - central application
-   run `php artisan serve --host=tenant.localhost` - tenant application, see docs regarding adding the local domains on your system
-   Create tenant and domain manually by going to central app url and registering OR run `php artisan tenants:pull --type=demo`
-   Compiling webpack for both central and themes: `yarn dev` (not in watch mode)
-   Compiling for central: `npx mix --mix-config="webpack.mix.js` (from root directory)
-   Compiling specific theme: `npx mix --mix-config="themes/{theme-name}/webpack.mix.js"`
- Build script: `yarn prod-all` and `yarn dev-all` fro development purposes.
# Local setup for assets
To download dependecies and build assets:

-   `yarn install`
-   `yarn dev`

After creating new tenant on local version: `127.0.0.1:8000`

You should see in central app database table `tenants` new row with details

And in `domains` table , you should see added domain details.

-   You might need to edit it manually to fit your local setup.
-   You need to modify your hosts file by running `sudo nano /etc/hosts`
-   You need to run another `php artisan serve --host=test.localhost` process with your desired domain name

# Routing
All tenant routes should be located in `routes/tenant.php`
All tenant dashboard admin routes should be located in `routes/dashboard.php`
All Central app routes should be located in `routes/web.php`

# Filesystem
In config you need to define `FILESYSTEM_DISK` to `s3` , but it's actually using *DigitalOcean Spaces*
Access Details can be found in `.env.example` file

# User Permissions
All permissions are added inside `App\Http\Services\PermissionsService.php`.
After permissions are added to the service class, they have to be added to the DB using:
- `php artisan permissions:populate --tenant_id={tenant_id}`

IMPORTANT: After adding/removing/changing permissions, run: 
- `php artisan cache:forget spatie.permission.cache`
- `php artisan cache:clear`

# Seeding universal payment methods
Run: UniversalPaymentMethodsTableSeeder.php: 

`php artisan tenants:seed --class=UniversalPaymentMethodsTableSeeder`

# Ceating Products stock for all products which don't have it (like legacy products)
Runs: CreateStockForAllProducts.php: 

`php artisan command:create_product_stock --tenant_id={tenant_id}`


# Data tables
rappasoft/livewire-datatables

# Components

Please see Components.md file, for more information, right now we add any dynamic and component usage examples in Components.md file

# Usage Of The Images
All Images that have `galleryTrait` can have access 
* You must add `uploadTrait ` to utilize `galleryTrait`

### Example Of Gallery usage 

```
$options = [
    'w' => 100,
    'h' => 100, // Auto height can be set if you remove 'h' property
]
```

*getGallery($options)* 

```
@foreach($product->getGallery(['w' => 300]) as $item)
    <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$item ?? ''">
    </x-tenant.system.image>
@endforeach
```

*getThumbnail($options)*

```
  <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$product->getThumbnail() ?? ''">
  </x-tenant.system.image>
```

*getCover($options)*
```
<x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$product->getCover() ?? ''">
</x-tenant.system.image>
```

and *get

# Image Optimization and dynamic images

For images optimization and resizing this project uses this library:
https://imgproxy.net/

All images sent via `images.we-saas.com` will get resized and converted to desired formats (WEBP included)

All urls that are passed via `uploaded_asset` function, will inherit image proxy for webp and reizing:

```

            $proxy_image = config('imgproxy.host').'/insecure/fill/0/0/ce/0/plain/'.$id.'@webp';

```

Please Include these `.env` variables on your local instance:

```

IMGPROXY_ENABLED=true
IMGPROXY_HOST=https://images.we-saas.com
IMGPROXY_KEY=6d1ac226357a834aa0ddda01e7697c0a93ce7dcc22b0620568efaadeb8681b5ddf1086b39ba358910e9009738efca8eced958b570149189c618688f4c6e9d290
IMGPROXY_SALT=d6582e38a7bfe441518fa8c7ee3613563a47a37615acfe8640d19af38cc1e786f3141232cdd9117362c60077f382ef02473b3fe36c223a1cd2139c87322fcb87
IMGPROXY_IGNORE_SSL_VERIFICATION=true
IMGPROXY_ENABLE_WEBP_DETECTION=true

```


## Model Caching
Some models like `App\Models\Translation`, `Product`, `EV_Label` are using cachable trait from this package:
https://github.com/GeneaLabs/laravel-model-caching

```
It has some compatability issues, so please check if you're not using package in the list of these packages:
grimzy/laravel-mysql-spatial
fico7489/laravel-pivot
chelout/laravel-relationship-events
spatie/laravel-query-builder
dwightwatson/rememberable
kalnoy/nestedset
```

## Demo Login Details:

**Admin**

`team@eim.solutions` / `123456`

**Customer**

`customer@eim.solutions` / `123456`

**Seller**

`seller@eim.solutions`/ `123456`
```
