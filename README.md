[![buddy pipeline](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136/badge.svg?token=35b16afac4ba4dae4724876e550894984b5e2ac6eb9da98b094b339061ed9ad1 "buddy pipeline")](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136) \
A complete solution for E-commerce Business with exclusive features & super responsive layout

#Local setup
* After checking out project from git
* Edit your `.env`
* run `php artisan migrate --path=/database/migrations/central`
* run `php artisan migrate --path=/database/migrations/tenant`
* run `php artisan serve` - central application
* run `php artisan serve --host=tenant.localhost` - tenant application, see docs regarding adding the local domains on your system


#local setup for assets
In case you running into issues with wcompile permissions run
`chmod 777 wcompile.sh`

To download dependecies and build assets:
* `yarn install`
* `yarn dev`

After creating new tenant on local version: `127.0.0.1:8000`

You should see in central app database table `tenants` new row with details

And in `domains` table , you should see added domain details. 

* You might need to edit it manually to fit your local setup.
* You need to modify your hosts file by running `sudo nano /etc/hosts`
* You need to run another `php artisan serve --host=test.localhost` process with your desired domain name

#Routing
All tenant routes should be located in `routes/tenant.php` 
All Central app routes should be located in `routes/web.php`

#Filesystem
In config you need to define `FILESYSTEM_DRIVER` to `s3` , but it's actually using DigitalOcean Spaces
Access Details can be found in `.env.example` file

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
