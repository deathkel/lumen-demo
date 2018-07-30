#!/bin/bash

echo "Configuring Develop Environment..."

appName="lumen_demo";

mkdir -p /www/privdata/log

echo "Configuring Nginx"
cp /www/${appName}/assets/provision/config/sites/*    /etc/nginx/sites-enabled/

echo "Using Composer to pull relative Project"
composer config -g repo.packagist composer https://packagist.phpcomposer.com && composer config -g secure-http false && cd /www/${appName} && composer update -o --no-plugins --no-scripts

echo "Start Supervisord"
/usr/bin/python2 /usr/bin/supervisord -n -c /etc/supervisord.conf > /dev/null 2>&1 &

echo "Finish Configure"
while true
do
    echo "hello world" > /dev/null
    sleep 6s
done


