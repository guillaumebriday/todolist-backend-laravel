# Todolist-backend Application

> Backend for https://github.com/guillaumebriday/todolist-frontend app, built for a serie of articles on my [blog](https://guillaumebriday.fr/).

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

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
