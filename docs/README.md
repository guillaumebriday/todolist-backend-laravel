# Todolist docs

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)
[![Netlify Status](https://api.netlify.com/api/v1/badges/49aa81a3-b064-4418-a40f-3e9f4e19d309/deploy-status)](https://app.netlify.com/sites/todolist-docs/deploys)

> Documentation for https://github.com/guillaumebriday/todolist-backend-laravel app, built for a serie of articles on my [blog](https://guillaumebriday.fr/).

## Some of the tools used in this project

- [Vuepress](https://vuepress.vuejs.org/)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/todolist-backend-laravel.git
$ cd todolist-backend-laravel
$ docker-compose run --rm node yarn
$ docker-compose run --service-ports --rm node yarn dev
```

## Useful commands
Building the app :
```bash
$ docker-compose run --rm node yarn dev

# or

$ docker-compose run --rm node yarn production
```

## Deploy in production

This application is hosted on [Netlify](https://www.netlify.com/) and available on [https://todolist-docs.guillaumebriday.xyz/](https://todolist-docs.guillaumebriday.xyz/).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
