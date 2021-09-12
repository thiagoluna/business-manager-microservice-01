#!/bin/bash

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh
chown -R www-data:www-data .
composer install
php artisan queue:work

php-fpm
