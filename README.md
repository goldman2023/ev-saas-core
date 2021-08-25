[![buddy pipeline](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136/badge.svg?token=35b16afac4ba4dae4724876e550894984b5e2ac6eb9da98b094b339061ed9ad1 "buddy pipeline")](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136) \
A complete solution for E-commerce Business with exclusive features & super responsive layout

#Local setup

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
-   Compiling specific theme watch: `npx mix watch --mix-config="themes/{theme-name}/webpack.mix.js"`

#local setup for assets
In case you running into issues with wcompile permissions run
`chmod 777 wcompile.sh`

To download dependecies and build assets:

-   `yarn install`
-   `yarn dev`

After creating new tenant on local version: `127.0.0.1:8000`

You should see in central app database table `tenants` new row with details

And in `domains` table , you should see added domain details.

-   You might need to edit it manually to fit your local setup.
-   You need to modify your hosts file by running `sudo nano /etc/hosts`
-   You need to run another `php artisan serve --host=test.localhost` process with your desired domain name

#Routing
All tenant routes should be located in `routes/tenant.php`
All Central app routes should be located in `routes/web.php`

#Filesystem
In config you need to define `FILESYSTEM_DRIVER` to `s3` , but it's actually using DigitalOcean Spaces
Access Details can be found in `.env.example` file

#Dynamic Components for

* Labels
``

#Data tables
This project uses Livewire DataTables package: https://github.com/mediconesystems/livewire-datatables

Example Component usage:
`<livewire:datatable model="App\Models\Product" :exclude="['video_link', 'description', 'user_id']"/>`

#Components

Please see Components.md file, for more information, right now we add any dynamic and component usage examples in Components.md file

#Image Optimization and dynamic images

For images optimization and resizing this project uses this library:
https://imgproxy.net/

All images sent via `images.ev-saas.com` will get resized and converted to desired formats (WEBP included)

All urls that are passed via `uploaded_asset` function, will inherit image proxy for webp and reizing:

```
            $proxy_image = config('imgproxy.host').'/insecure/fill/0/0/ce/0/plain/'.$id.'@webp';
```

Please Include these `.env` variables on your local instance:
```
IMGPROXY_ENABLED=true
IMGPROXY_HOST=https://images.ev-saas.com
IMGPROXY_KEY=6d1ac226357a834aa0ddda01e7697c0a93ce7dcc22b0620568efaadeb8681b5ddf1086b39ba358910e9009738efca8eced958b570149189c618688f4c6e9d290
IMGPROXY_SALT=d6582e38a7bfe441518fa8c7ee3613563a47a37615acfe8640d19af38cc1e786f3141232cdd9117362c60077f382ef02473b3fe36c223a1cd2139c87322fcb87
IMGPROXY_IGNORE_SSL_VERIFICATION=true
IMGPROXY_ENABLE_WEBP_DETECTION=true
```

**Project URL:**

https://app.ev-saas.com

## Documentation:

https://docs.ev-saas/

## Demo Login Details:

**Admin**

`team@eim.solutions` / `123456`

**Customer**

`customer@eim.solutions` / `123456`

**Seller**

`seller@eim.solutions`/ `123456`
