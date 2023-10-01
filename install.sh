#!/bin/bash

# This is a simple script to run multiple commands
cp .env.example .env

php artisan key:generate

composer install

php artisan sail:add 0
php artisan sail:add 3

alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

sail up

sail artisan migrate

sail artisan db:seed --class=UserSeed
sail artisan db:seed --class=BrandSeed
php artisan l5-swagger:generate