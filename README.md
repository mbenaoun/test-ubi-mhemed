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

We are 6 route : 

- POST user
- PATCH user
- DELETE user
- POST notation user
- GET avg user
- GET avg users

The format by default is JSON

## Utils

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

