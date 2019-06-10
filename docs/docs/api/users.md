# Accounts and users

The following endpoints can be used to manage your account.

## Register

Register an account and returns JWT informations.

```bash
$ POST /api/v1/auth/register
```

### Request

Query Parameters :

| Name     | Rules                                 | Description   |
|----------|---------------------------------------|---------------|
| name     | `required|alpha_dash|max:255`         | Your name     |
| email    | `required|email|max:255|unique:users` | Your email    |
| password | `required|string|min:6|confirmed`     | Your password |

Example :
```json
{
    "name": "Anakin",
    "email": "darthvader@deathstar.ds",
    "password": "4nak1n",
    "password_confirmation": "4nak1n"
}
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
    "token_type": "bearer",
    "expires_in": "86400",
    "user_id": 1
}
```

::: danger Error
**Status**: 422 Unprocessable Entity
:::

Example :
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

## Login

Login an account and returns JWT information.

```bash
$ POST /api/v1/auth/login
```

### Request

Query Parameters :

| Name     | Rules             | Description   |
|----------|-------------------|---------------|
| email    | `required|email`  | Your name     |
| password | `required|string` | Your password |

Example :
```json
{
    "email": "darthvader@deathstar.ds",
    "password": "4nak1n"
}
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
    "token_type": "bearer",
    "expires_in": "86400",
    "user_id": 1
}
```

::: danger Error
**Status**: 401 Unauthorized
:::

Example :
```json
{
    "errors": {
        "email": [
            "These credentials do not match our records."
        ]
    }
}
```

::: danger Error
**Status**: 422 Unprocessable Entity
:::

Example :
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

## Logout

Log the user out - which will invalidate the current token and unset the authenticated user.

```bash
$ DELETE /api/v1/auth/logout
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "message": "Successfully logged out"
}
```

::: danger Error
**Status**: 401 Unauthorized
:::

Example :
```json
{
    "message": "Unauthenticated."
}
```

## Me

Returns informations about the authenticated user.

```bash
$ GET /api/v1/auth/me
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "data": {
        "id": 1,
        "name": "Anakin",
        "email": "darthvader@deathstar.ds"
    }
}
```

::: danger Error
**Status**: 401 Unauthorized
:::

Example :
```json
{
    "message": "Unauthenticated."
}
```

## Refresh token

Refresh a token, which invalidates the current one

```bash
$ POST /api/v1/auth/refresh
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
    "token_type": "bearer",
    "expires_in": "86400",
    "user_id": 1
}
```

::: danger Error
**Status**: 401 Unauthorized
:::

Example :
```json
{
    "message": "Unauthenticated."
}
```

## Update your account

Update and returns an user. You can only update your own account.

Params are optionals and fields won't be updated if the params are undefined.

```bash
$ PATCH|PUT /api/v1/users/:id
```

### Request

Query Parameters :

| Name             | Rules                        | Description           |
|------------------|------------------------------|-----------------------|
| name             | `alpha_dash|max:255`         | Your name             |
| email            | `email|max:255|unique:users` | Your email            |
| current_password | `required_with:password`     | Your current password |
| password         | `string|min:6|confirmed`     | Your new password     |

Example :
```json
{
    "name": "Ben",
    "email": "ben@kenobi.jo",
    "current_password": "4nak1n",
    "password": "4_n3w_h0p3",
    "password_confirmation": "4_n3w_h0p3"
}
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "data": {
        "id": 1,
        "name": "Ben",
        "email": "ben@kenobi.jo"
    }
}
```

::: danger Error
**Status**: 401 Unauthorized
:::

Example :

```json
{
    "message": "Unauthenticated."
}
```

::: danger Error
**Status**: 403 Forbidden
:::

Example :

```json
{
    "message": "This action is unauthorized."
}
```

::: danger Error
**Status**: 422 Unprocessable Entity
:::

Example :

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "current_password": [
            "The current password field is required when password is present."
        ],
        "password": [
            "The password confirmation does not match."
        ]
    }
}
```

::: danger Error
**Status**: 404 Not Found
:::

Example :

```json
{
    "message": "No query results for model [App\\Models\\User]."
}
```

## Delete your account

Deleting your account will also delete your tasks.

```bash
$ DELETE /api/v1/users/:id
```

### Responses

::: tip Success
**Status**: 204 No Content
:::

::: danger Error
**Status**: 401 Unauthorized
:::

Example :

```json
{
    "message": "Unauthenticated."
}
```

::: danger Error
**Status**: 403 Forbidden
:::

Example :

```json
{
    "message": "This action is unauthorized."
}
```

::: danger Error
**Status**: 404 Not Found
:::

Example :

```json
{
    "message": "No query results for model [App\\Models\\User]."
}
```
