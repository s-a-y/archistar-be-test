At first I thought of using apiato framework (on top of Laravel), which provides excellent API management capabilities: auth, rate-limiting, comprehensive logging, versioning, API doc generation, etc.  But quickly realized that it does most of the job for me and you won’t really see
me doing stuff as it generates too much boilerplate code. So for the readability I went back to pure Laravel setup.

I’d normally just drop laradock into a new project for easy docker setup of local environment, but it takes 10 min to run for the first time, so I decided to make a simple docker-compose file myself.

docker-compose up -d

I'm going to write step by step how I did everything, to setup project locally follow the same steps.

`cp .env.example .env`

changed some parameters, mostly database connection
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=archistar
DB_USERNAME=user
DB_PASSWORD=secret
```

docker-compose run --rm composer install
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan make:migration ArchistarScheme

Prepared migration and the seed file

docker-compose run --rm artisan migrate
docker-compose run --rm artisan db:seed
