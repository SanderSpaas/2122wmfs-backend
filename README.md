# Project Gotcha Backend
Setup info to setup the backend for Gotcha


## Installing the backend
Pull the project to a folder of your preference.

## Quick configuration of the Laravel project

You still need to install the libraries in the vendor folder (because they are not on git) and do some basic configuration like generating the key, linking the storage &hellip;
* Run from your terminal/cmd
```shell
docker-compose exec -u 1000:1000 php-web bash
$ composer install
$ php artisan key:generate
$ touch storage/logs/laravel.log
$ php artisan storage:link
$ exit
```
## In your .env file
fill in:
APP_KEY
DB_DATABASE
DB_USERNAME
DB_PASSWORD

Make sure to put the right SANCTUM_STATEFUL_DOMAINS in your .env file. Also don't forget the SESSION_DOMAIN.
