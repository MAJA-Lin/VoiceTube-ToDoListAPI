# Backend Task

## Build a RESTful-API ecosystem for to-do list with Laravel, PHP 7.2, Nginx, MySQL.

### DB schema fields

```sql
`id`,
`title`,
`content`,
`attachment`,
`created_at`,
`done_at`,
`deleted_at`
```

### Minimum Requirments

1. JSON-API like response and JSON payload or multipart for requests
2. API that modifies data *must* be protected by tokens
3. Tokens can be self-designed or JWT token
4. Design DB schema by your self

### Optional

1. Optimize performance /w some other technologies
2. Create a local dev environment using Docker
3. Tokens with TTL
4. Tokens with RefreshToken

### API List

* get all to-do lists
* get one to-do list
* create one to-do list
* update one to-do list
* delete one to-do list
* delete all to-do list
* generate a new token
* get token status (Only if tokens with TTL or RefreshToken)

### Notice

Please upload your source code to GitHub or other similar service

---

### How to use

```shell
$ cp laradock-env ./laradock/.env
$ cd laradock
$ docker-compose up -d nginx mysql adminer redis
$ docker-compose exex -it workspace php artisan key:generate
```

Edit following configuration in **laravel .env** file

```config
DB_HOST=mysql
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret
```


### Optional

Import **VT-ToDoList API.postman_collection.json** to your Postman.