sentinelb
=========

backend for sentinel app

# Installation

Create your vagrant machine

# Clone repo

Clone your repo into vagrant.sentinelb.com/www/dev.sentinelb.com
cd www
git clone https://github.com/vincentserpoul/sentinelb.git dev.sentinelb.com

# On your VM

ssh to your vagrant machine
vagrant ssh

and type the following command in your terminal
cd /var/www/dev.sentinelb.com
composer create-project laravel/laravel --prefer-dist