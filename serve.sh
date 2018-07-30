#!/bin/bash
if [ $1 == 'start' ];then
    docker run -p 32773:80 -p 32772:443 -p 32771:9000 -v $(pwd):/var/www/site -itd --name lumen_demo deathillidan/laravel:latest
elif [ $1 == 'stop' ];then
    docker stop sl && docker rm sl
elif [ $a == 'reload' ];then
    docker reload sl
fi
