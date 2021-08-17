[![buddy pipeline](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136/badge.svg?token=35b16afac4ba4dae4724876e550894984b5e2ac6eb9da98b094b339061ed9ad1 "buddy pipeline")](https://app.buddy.works/b2bwood/b2bwood/pipelines/pipeline/323136) \
A complete solution for E-commerce Business with exclusive features & super responsive layout

#Local setup
* After checking out project from git
* Edit your `.env`
* run `php artisan migrate --path=/database/migrations/central`
* run `php artisan migrate --path=/database/migrations/tenant`
* run `php artisan serve` - central application
* run `php artisan serve --host=tenant.localhost` - tenant application, see docs regarding adding the local domains on your system
* Create tenant and domain manually by going to central app url and registering OR run `php artisan tenants:pull --type=demo`
* Compiling webpack for both central and themes: `yarn dev` (not in watch mode)
* Compiling for central: `npx mix --mix-config="webpack.mix.js` (from root directory)
* Compiling specific theme: `npx mix --mix-config="themes/{theme-name}/webpack.mix.js"`
* Compiling specific theme watch: `npx mix watch --mix-config="hemes/{theme-name}/webpack.mix.js"`


**Project URL:**

https://ev-saas.com

## Documentation:
https://docs.ev-saas/



## Demo Login Details:

**Admin**

`team@eim.solutions` / `123456`

**Customer**

`customer@eim.solutions` / `123456`

**Seller**

`seller@eim.solutions`/ `123456`
