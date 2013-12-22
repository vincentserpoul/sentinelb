sentinelb
=========

backend for sentinel app

# Installation

Create your vagrant machine (cf https://github.com/vincentserpoul/vagrant-php-env)

# Clone repo

Clone your repo into vagrant.sentinelb.com/www/dev.sentinelb.com

    cd vagrant.sentinelb.com/www/
    git clone git@github.com:vincentserpoul/sentinelb.git dev.sentinelb.com

# On your VM

ssh to your vagrant machine.

    vagrant ssh

and type the following command in your terminal

    cd /var/www/dev.sentinelb.com
    cd laravel
    sudo composer install
    sudo composer update
    mysql -udev -pdev -e "DROP DATABASE centuryevergreen;"
    mysql -udev -pdev -e "CREATE DATABASE centuryevergreen;"
    php artisan cache:clear
    php artisan migrate --env=local  --package=cartalyst/sentry
    php artisan migrate --env=local
    php artisan db:seed --env=local

Now open your browser and go to

        http://dev.sentinelb.com/api/v1/employee

You should see

        {"error":true,"message":"Please log in to continue."}

It's working!
