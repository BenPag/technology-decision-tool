# Technology Decision Tool

## Install
1. define MySql username and password in docker-compose.yml
2. move to backend folder and copy .env.example to .env
3. adjust the .env file
    * set unique base64 APP_KEY
    * set unique base64 JWT_SECRET
    * set MYSQL_USERNAME
    * set MYSQL_PASSWORD
4. run docker-compose up
5. open backend url e.g. http://localhost:8000/ for auto initialization

### Docker Compose commands
``` bash
# first start
docker-compose up
# stop all containers
docker-compose stop
# start all containers
docker-compose start
# shutdown and remove containers
docker-compose down
```

## Backend based on Laravel Lumen

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

### Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

### License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Frontend based on Vue.js

Vue.js is an MIT-licensed open source project with its ongoing development made possible entirely by the support of these awesome backers. 

### Official Documentation

To check out live examples and docs, visit vuejs.org.

### License

Vue.js is an MIT-licensed open source project [MIT license](https://opensource.org/licenses/MIT).
