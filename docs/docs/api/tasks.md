# Tasks

The following endpoints can be used to manage your tasks.

## Retrieve all tasks

```bash
$ GET /api/v1/tasks
```

### Responses

::: tip Success
**Status**: 200 OK
:::

Example :
```json
{
    "data": [
        {
            "id": 1,
            "title": "Buy pizza on the way to work",
            "due_at": null,
            "is_completed": false,
            "author": {
                "id": 1,
                "name": "Anakin",
                "email": "darthvader@deathstar.ds"
            }
        },
        {
            "id": 2,
            "title": "Give a star to this repo",
            "due_at": "2018-05-25T12:25:51+02:00",
            "is_completed": true,
            "author": {
                "id": 1,
                "name": "Anakin",
                "email": "darthvader@deathstar.ds"
            }
        }
    ]
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

## Retrieve a task

```bash
$ GET /api/v1/tasks/:id
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
        "title": "Buy pizza on the way to work",
        "due_at": null,
        "is_completed": false,
        "author": {
            "id": 1,
            "name": "Anakin",
            "email": "darthvader@deathstar.ds"
        }
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
**Status**: 404 Not Found
:::

Example :

```json
{
    "message": "No query results for model [App\\Models\\Task]."
}
```

## Store a new task

```bash
$ POST /api/v1/tasks
```

### Request

The `due_at` date will be converted from the timezone you specified and returned in UTC. You need to manage it in your application.

Query Parameters :

| Name         | Rules                     | Description                |
|--------------|---------------------------|----------------------------|
| title        | `required|string|max:255` | Title of the task          |
| due_at       | `nullable|date`           | Due date of the task       |
| is_completed | `boolean`                 | Check if task is completed |

Example :
```json
{
    "title": "A newly created task"
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
        "title": "A newly created task",
        "due_at": null,
        "is_completed": false,
        "author": {
            "id": 1,
            "name": "Anakin",
            "email": "darthvader@deathstar.ds"
        }
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
**Status**: 422 Unprocessable Entity
:::

Example :

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
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
    "message": "No query results for model [App\\Models\\Task]."
}
```

## Update a task

Update and returns a task.

```bash
$ PATCH|PUT /api/v1/tasks/:id
```

### Request

Query Parameters :

| Name         | Rules            | Description                |
|--------------|------------------|----------------------------|
| title        | `string|max:255` | Title of the task          |
| due_at       | `nullable|date`  | Due date of the task       |
| is_completed | `boolean`        | Check if task is completed |

Example :
```json
{
    "title": "An updated task",
    "is_completed": true
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
        "title": "An updated task",
        "due_at": null,
        "is_completed": true,
        "author": {
            "id": 1,
            "name": "Anakin",
            "email": "darthvader@deathstar.ds"
        }
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
**Status**: 422 Unprocessable Entity
:::

Example :

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "is_completed": [
            "The is completed field must be true or false."
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
    "message": "No query results for model [App\\Models\\Task]."
}
```

## Delete a task

```bash
$ DELETE /api/v1/tasks/:id
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
**Status**: 404 Not Found
:::

Example :

```json
{
    "message": "No query results for model [App\\Models\\Task]."
}
```

## Delete all completed tasks

```bash
$ DELETE /api/v1/tasks
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
