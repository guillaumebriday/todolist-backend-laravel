# Todolist-backend Application

[![Build Status](https://travis-ci.org/guillaumebriday/todolist-backend.svg?branch=master)](https://travis-ci.org/guillaumebriday/todolist-backend)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)

> Backend for https://github.com/guillaumebriday/todolist-frontend app, built for a serie of articles on my [blog](https://guillaumebriday.fr/).

The purpose of this repository is to provide API with [Laravel](http://laravel.com/) and connecting JavaScript front-end frameworks like [Vue.js](https://vuejs.org) or other clients to them.

Beside Laravel, this project uses other tools like :

- [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
- [Travis CI](https://travis-ci.org/)
- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup)
- [Redis](https://redis.io/)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/todolist-backend.git
$ cd todolist-backend
$ cp .env.example .env
$ docker-compose run --rm --no-deps todolist-server composer install
$ docker-compose run --rm --no-deps todolist-server php artisan key:generate
$ docker-compose run --rm --no-deps todolist-server php artisan jwt:secret
$ docker-compose up -d
```

## Before starting
You need to run the migrations :
```
$ docker-compose run --rm todolist-server php artisan migrate
```

## Useful commands
Running tests :
```
$ docker-compose run --rm todolist-server ./vendor/bin/phpunit
```

Running php-cs-fixer :
```
$ docker-compose run --rm --no-deps todolist-server ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Generating backup :
```
$ docker-compose run --rm todolist-server php artisan backup:run --only-db
```

Discover package
```
$ docker-compose run --rm --no-deps todolist-server php artisan package:discover
```

## More details

More details are available on my blog post : [https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs](https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
