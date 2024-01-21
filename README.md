## Specifications / Infrastructure Information

-   Nginx
-   PHP-FPM
-   MySQL
-   Redis

## Prerequisites

-   [Git](https://git-scm.com/downloads)
-   [Docker Desktop](https://www.docker.com/products/docker-desktop)

# Getting Started

## Build the all containers

```

docker-compose build

```

To build/rebuild a specific container, run the following command, CONTAINER_NAME is from the `docker-compose.yml`

```

docker-compose build CONTAINER_NAME

```

Start the containers

```

docker-compose up

---

## Composer

Install the composer packages of your project

```

## docker-compose run --rm composer install

## Setting up Laravel

Create the `.env` file and run the following to generate key for Laravel

```

docker-compose run php cp .env.example1 .env

```

Update the `.env` values especially the database credentials then refresh the config

```

docker-compose exec app php artisan config:clear

```

Run the migration

```

docker-compose exec app php artisan migrate:fresh

```

After setting up all the values in the `.env` file, run the following command to make sure the environment variables are updated successfully.

```

docker-compose exec app php artisan config:clear

```

To enable to save image in public directory

```

docker-compose exec app php artisan storage:link

```

Use the POSTMAN collection for testing the endpoints

```

```
