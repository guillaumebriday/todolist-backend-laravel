# Todolist-backend Application

[![pipeline status](https://gitlab.com/guillaumebriday/todolist-backend-laravel/badges/master/pipeline.svg)](https://gitlab.com/guillaumebriday/todolist-backend-laravel/pipelines)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)

> Backend for https://github.com/guillaumebriday/todolist-frontend-vuejs app, built for a serie of articles on my [blog](https://guillaumebriday.fr/).

The purpose of this repository is to provide API with [Laravel 5.8](http://laravel.com/) and connecting JavaScript front-end frameworks like [Vue.js 2](https://vuejs.org) or other clients to them.

Beside Laravel, this project uses other tools like :

- [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
- [Travis CI](https://travis-ci.org/)
- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup)
- [Pusher](https://pusher.com/)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com) >= 17.06 CE
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/todolist-backend-laravel.git
$ cd todolist-backend-laravel
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

Seed the database :
```
$ docker-compose run --rm todolist-server php artisan db:seed
```

This will create a new user that you can use to sign in :
```
Email : darthvader@deathstar.ds
Password : 4nak1n
```

## Useful commands
Running tests :
```
$ docker-compose run --rm todolist-server ./vendor/bin/phpunit --cache-result --order-by=defects --stop-on-defect
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

Generating fake data :
```bash
$ docker-compose run --rm todolist-server php artisan db:seed --class=DevDatabaseSeeder
```

## Accessing the API

Clients can access to the REST API. API requests require authentication via JWT. You can create a new one with you credentials.

```bash
$ curl -X POST http://localhost:8000/api/v1/auth/login -d "email=your_email&password=your_password"
```

Then, you can use this token either as url parameter or in Authorization header :

```bash
# Url parameter
curl -X POST http://localhost:8000/api/v1/auth/me?token=your_jwt_token_here

# Authorization Header
curl -X POST --header "Authorization: Bearer your_jwt_token_here" http://localhost:8000/api/v1/auth/me
```

API are prefixed by ```api``` and the API version number like so ```v1```.

Do not forget to set the ```X-Requested-With``` header to ```XMLHttpRequest```. Otherwise, Laravel won't recognize the call as an AJAX request.

To list all the available routes for API :

```bash
$ docker-compose run --rm --no-deps todolist-server php artisan route:list
```

You can import my [Insomnia](https://insomnia.rest/) workspace configured to work with the API : `.insomnia/todolist-backend-laravel.json`.

## Broadcasting & WebSockets

Before using WebSockets, you need to set the ```PUSHER``` related keys in your .env file.

You could find this keys on [https://pusher.com/](https://pusher.com/).

You also need to set the ```BROADCAST_DRIVER``` key :

```
BROADCAST_DRIVER=pusher
```

## Deploy in production

You can serve your application with [nginx](https://nginx.org/) in production.

You can deploy this application with [Ansible](https://www.ansible.com).

Copy the hosts example file and change the values to your needs :

```bash
$ cp hosts.example hosts
```

Setup your variables in the ```playbook.yml```.

And then run :

```bash
$ ansible-playbook -i hosts playbook.yml
```

Build the images :
```bash
$ docker build -f .cloud/docker/Dockerfile.prod --target application -t todolist-backend-laravel-application .

$ docker build -f .cloud/docker/Dockerfile.prod --target nginx -t todolist-backend-laravel-nginx .
```

Run the containers :
```bash
$ docker run --rm -it --name todolist-server --link some-mysql:mysql --env-file .env --network todolist-backend todolist-backend-laravel-application

$ docker run --rm -it -p 8000:8000 --network todolist-backend todolist-backend-laravel-nginx
```

## Consume the API

The application is available on [https://todolist-api.guillaumebriday.xyz/api/v1/](https://todolist-api.guillaumebriday.xyz/api/v1/).

The documentation is available in the `docs` folder or on [https://todolist-docs.guillaumebriday.xyz](https://todolist-docs.guillaumebriday.xyz).

You can consume the API with any client.

Some examples of projects who use this API:
+ [https://github.com/guillaumebriday/todolist-frontend-vuejs](https://github.com/guillaumebriday/todolist-frontend-vuejs) (Vue.js)
+ [https://github.com/benoitrongeard/todolist-angular](https://github.com/benoitrongeard/todolist-angular) (Angular 6)

Don't forget to let me know if you want to add your project to this list !

## More details

More details are available on my blog post : [https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs](https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
