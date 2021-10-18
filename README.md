### Server requirements
* PHP >= 7.4
* BCMath PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

### Setup
In project folder open terminal and run:

##### Install vendors for project

``
composer install
``

##### Setup database

Create a new mysql database or sqlite and add config in .env

Run command to setup table and generate data for project.

``
php artisan migrate --seed
``

### Test Api with swagger

Add setting for swagger:
```text
SWAGGER_VERSION=3.0
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_GENERATE_YAML_COPY=true
L5_SWAGGER_OPERATIONS_SORT=alpha
```

or run command:

```
php artisan l5-swagger:generate
```

Open this url to see document api:

``http://{domain}/api/documentation``

Use api login to get access_token and set this token in auth of Swagger document like:

``Bearer token``

#### Unit test

In root folder run command

```ssh
vendor\bin\phpunit.bat
```

If you wanna using coverage view you need install xdebug
