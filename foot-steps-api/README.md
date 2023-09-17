### Foot step service
This service provide APIs for foot step.

### Requirements

- PHP 7.4 (DEV using deb package) or 7.4 (PROD using docker image on k8s) or newer
- [Composer](http://getcomposer.org)
- [Laravel](https://laravel.com/) 8.4
- Docker and Docker Compose
- Approach DDD principle

### Installation

Copy the `.env` file

```
cp env.example .env
```

Build docker image (cached or non-cache)

```
docker-compose build
```

```
docker-compose build --no-cache
```

Run docker image

```
docker-compose up
```

Run the following command to install the package through Composer:

```bash
docker-compose exec php composer self-update --2
docker-compose exec php composer install
```

Generate application key

```
docker-compose exec php php artisan key:generate
```

### Usage

Stop docker

```
docker-compose down
```

### Check production image on local

Replace original docker-compose.yml with deploy/docker-compose.yml. When done please revert back original docker-compose.yml

#### API documentation
- Dev: https://localhost:9084
