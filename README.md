# Test UBI - M'hemed BEN AOUN

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

* [Git](https://git-scm.com)
* [Docker](https://www.docker.com/get-docker)

### Installing

1) Clone project.
```
https://github.com/mbenaoun/test-ubi-mhemed.git
```

2) Build contener with docker.
```
docker-compose build
docker-compose up
```

We are 4 containers created in docker : 

- test-ubi-mhemed_php_1 : Server PHP (Application)
- test-ubi-mhemed_mysql_1 : Server MySQL
- test-ubi-mhemed_redis_1 : Server Redis
- test-ubi-mhemed_nginx_1 : Server Nginx

3) Run composer.
```
docker exec -it test-ubi-mhemed_php_1 composer install
```

7) Go to [http://test-ubi.mhemed](http://test-ubi.mhemed) (To See Routes in API DOC)

We are 6 route : The format by default is JSON

- POST user : /users

BODY : {"lastName":"TEST","firstName":"TEST","dateOfBirth":"1993-11-22"}

- PATCH user : /users/{userId} (userId : int)
  
BODY : {"lastName":"TEST","firstName":"TEST","dateOfBirth":"1993-11-22"}

- DELETE user : /users/{userId} (userId : int)
  
NO BODY

- POST notation user : /notations

BODY : {"subject":"TEST","score":5.5,"user":"users/USER_ID"}

- GET avg user : /users/{userId}/avg (userId : int)

NO BODY

- GET avg users : /notations/avg

NO BODY

## Utils

### Testing

- Connection PHP Container

```
docker exec -it test-ubi-mhemed_php_1 bash
```

- Launch Unit Test
```
php vendor/bin/codecept run unit
```

We can see in console output the result unit functions (failed and or success functions)

- Show Code Coverage Report (Unit Test example)
```
php vendor/bin/codecept run unit --coverage-html
```

After we open the file index.html in chrome => test-ubi-mhemed/tests/_output/coverage/index.html.

### Cache (Redis)

- Connection Redis Container

```
docker exec -it test-ubi-mhemed_redis_1 bash
```

- Run command redis-cli
```
redis-cli
```

- Show Keys Stored in Redis
```
KEYS *
```

- Show Value Key in Redis

```
GET avg-users-17
```

### PhpCsFixer

- Connection API Container or Terminal local in your project (PHP 7.4 required)

```
docker exec -it test-ubi-mhemed_php_1 bash
```
- Launch PhpCsFixer to fix code (rules define in .php_cs.dist)
```
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --no-interaction
```

- Keyboard shortcut to launch PhpCsFixer since your IDE

1) Create external tools in your IDE (preferences / tools / external tools)
2) Create Keyboard shortcut in your IDE (preferences / keymap)



