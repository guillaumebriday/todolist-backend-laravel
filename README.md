# Todolist-backend Application

[![Build Status](https://travis-ci.org/guillaumebriday/todolist-backend-laravel.svg?branch=master)](https://travis-ci.org/guillaumebriday/todolist-backend-laravel)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)

> Backend for https://github.com/guillaumebriday/todolist-frontend-vuejs app, built for a serie of articles on my [blog](https://guillaumebriday.fr/).

The purpose of this repository is to provide API with [Laravel 5.6](http://laravel.com/) and connecting JavaScript front-end frameworks like [Vue.js](https://vuejs.org) or other clients to them.

Beside Laravel, this project uses other tools like :

- [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
- [Travis CI](https://travis-ci.org/)
- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- [spatie/laravel-cors](https://github.com/spatie/laravel-cors)
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup)
- [Pusher](https://pusher.com/)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/todolist-backend-laravel.git
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
$ docker-compose run --rm todolist-server ./vendor/bin/phpunit --stop-on-failure
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

## Broadcasting & WebSockets

Before using WebSockets, you need to set the ```PUSHER``` related keys in your .env file.

You could find this keys on [https://pusher.com/](https://pusher.com/).

You also need to set the ```BROADCAST_DRIVER``` key :

```
BROADCAST_DRIVER=pusher
```

## Deploy in production

You can serve your application with [nginx](https://nginx.org/) in production.

You can deploy this application with [Ansible](https://www.ansible.com) and [Capistrano](http://capistranorb.com/).

Just create an ```hosts``` file like the following one :

```ini
[webservers]
example.com

[all:vars]
ansible_python_interpreter=/usr/bin/python3

[webservers:vars]
app_url=example.com

app_key=generate-me
jwt_secret=generate-me

db_database=change-me
db_username=root
db_password=change-me

mail_driver=smtp
mail_host=smtp.example.com
mail_port=25
mail_username=change-me
mail_password=change-me

pusher_app_id=a1b2c3d4
pusher_app_key=a1b2c3d4
pusher_app_secret=a1b2c3d4
pusher_app_cluster=eu
```

Setup your variables in the ```playbook.yml``` and in the ```config/deploy.rb``` files.

And then run :

```bash
$ ansible-playbook -i hosts playbook.yml
```

Now with [Capistrano](http://capistranorb.com/) :

Before starting, change the configuration files with your informations, then run :

```bash
$ bundle install
$ cap production deploy
```

The first deployment might fail because mysql is not fully loaded. In this case just deploy again.

## More details

More details are available on my blog post : [https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs](https://guillaumebriday.fr/laravel-vuejs-faire-une-todo-list-partie-1-presentation-et-objectifs) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
