# lumen demo

#### 项目介绍
lumen api demo with JWT, Wechat, Docker, API DOC, PHPUnit etc..

##### 需求依赖
* lumen >= 5.6
* php >= 7.1.3
* jwt: [lcobucci/jwt](https://github.com/lcobucci/jwt.git)
* api_doc: [deathkel/api-test](https://github.com/deathkel/apiTest.git)


##### 需求依赖可选
1. docker、 docker-compose
2. docker镜像 [deathillidan/laravel](https://hub.docker.com/r/deathillidan/laravel/),基于[richarvey/nginx-php-fpm](https://hub.docker.com/r/richarvey/nginx-php-fpm/)定制

#### FEATURE
* jwt
    * middleware
* wechat
    * 小程序登录
* api文档
    * 使用[deathkel/api-test](https://github.com/deathkel/apiTest.git)
* PHPUnit
            
#### TODO


#### 使用docker搭建统一开发环境

1. 安装docker
2. 拉docker image
    * docker pull jwilder/nginx-proxy
    * docker pull deathillidan/laravel:latest

3. 创建container
    * docker network create nginx-proxy

4. docker-compose
    * 启动 docker-compose up

5. 配置本机host
    * 127.0.0.1 api.lumen_demo.test
 
6. 测试站点是否正常
    * api: api.lumen_demo.test
    
7. docker相关命令
    * 一个使用Docker容器的应用，通常由多个容器组成。使用Docker Compose，不再需要使用shell脚本来启动容器。在配置文件中，所有的容器通过services来定义，然后使用docker-compose脚本来启动，停止和重启应用，和应用中的服务以及所有依赖服务的容器。完整的命令列表如下：  
     <pre>
             build 构建或重建服务
             help 命令帮助
             kill 杀掉容器
             logs 显示容器的输出内容
             port 打印绑定的开放端口
             ps 显示容器
             pull 拉取服务镜像
             restart 重启服务
             rm 删除停止的容器
             run 运行一个一次性命令
             scale 设置服务的容器数目
             start 开启服务
             stop 停止服务
             up 创建并启动容器
     </pre>
    
8. 常用docker命令
    <pre>
    创建容器: docker-compose up --force-recreate --remove-orphans  前台启动(-d 后台启动)
    进入容器: docker exec -it lumen_demo /bin/bash
    开启容器: docker-compose start
    停止容器: docker-compose stop
    重启容器: docker-compose restart
    删除容器: docker-compose down
    </pre>

#### 服务器部署
* 简单使用`docker run -P -v $(pwd):/var/www/site -itd deathillidan/laravel:latest`
* 指定端口 `-p 32773:80 -p 32772:443 -p 32771:9000`
