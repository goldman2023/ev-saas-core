# Local Setup

To run this project on your machine you need to do following steps:

* Checkout or clone this repository via git
* Add database credentials to `.env` file
* Run: `composer install`
* Run: `npm install`  
* Run: `php artisan migrate:fresh --seed` **run this for the first time only**
* Run `php artisan db:seed`
* Run `php artisan serve` - for local server
* Run `npm run watch` - for building assets


After completing these steps you should see homepage on your local url:

Example URL: `http://127.0.0.0:8000`
# Docker Setup 
Requirements:
- [x] check [docker](https://www.docker.com/get-started) and [docker-compose](https://docs.docker.com/compose/install/) installed

## Installation

---
**P.S: these steps below should be running within the directory where docker-compose exists**
1. copy `.env.docker` to `.env` setup all environment variables including docker variables
2. building the app `docker-compose up -d --build`
    1. access your db client app of your choice and login to your db or you can access phpmyadmin `http://localhost:8080` (you can edit these var in `.env` before running step above) \
       host: `db` \
       port: `3306` \
       user: `user` \
       password: `123456` \
> the app will take around 5-10 minutes to build and run app
**P.S: The app will be served on https://localhost**

#### Bonus
1. To stop the app run in terminal `docker-compose down`
2. In order to access shell terminal in a specific container `docker-compose exec <container-name> sh`
   replace `container-name` with the containers names below \
   `app` :  laravel app contains (npm, composer) \
   `cache`: redis cache server \
   `nginx`: nginx server \
   `db`: mysql database \
   `phpmyadmin` : phpmyadmin
3. In order to run npm run watch `docker-compose exec app npm run watch`
