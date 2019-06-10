# Getting Started

[Todolist-backend Application](https://github.com/guillaumebriday/todolist-backend-laravel) offers several tools and APIs to manage a real world Todolist application.

[Todolist-frontend Application](https://github.com/guillaumebriday/todolist-frontend-vuejs) is an example of a client for this API build with Vue.js

In this documentation, you'll find tips to help you get up and running on a new client application.

## Content type

The API only respond with the `Content-Type` header to `application/json`.

## API Version

API are prefixed by `api` and the API version number like so `/api/v1`.

## Ajax header

Do not forget to set the `X-Requested-With` header to `XMLHttpRequest`. Otherwise, Laravel won't recognize the call as an AJAX request.

Example with axios :

```js
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
}
```

## Authentication

Clients can access to the REST API. API requests require authentication via JWT.

Then, you can use this token either as url parameter or in Authorization header :

```bash
# Url parameter
$ curl -X POST /api/v1/auth/me?token=your_jwt_token_here

# Authorization Header
$ curl -X POST --header "Authorization: Bearer your_jwt_token_here" /api/v1/auth/me
```

## Rate limit

An authenticated user may access the API **60 times** per **minute**.
