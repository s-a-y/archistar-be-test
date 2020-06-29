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

```
docker-compose run --rm composer install
docker-compose run --rm artisan key:generate
docker-compose run --rm artisan make:migration ArchistarScheme
```

Prepared migration and the seed file

```
docker-compose run --rm artisan migrate
docker-compose run --rm artisan db:seed
```
Modified routes/api to include all required API endpoints
```
+--------+-----------+------------------------------------------------+------------------+-----------------------------------------------------+------------+
| Domain | Method    | URI                                            | Name             | Action                                              | Middleware |
+--------+-----------+------------------------------------------------+------------------+-----------------------------------------------------+------------+
|        | GET|HEAD  | /                                              |                  | Closure                                             | web        |
|        | POST      | api/properties                                 | properties.store | App\Http\Controllers\API\PropertiesController@store | api        |
|        | GET|HEAD  | api/properties/{property}/analytics            | analytics.index  | App\Http\Controllers\API\AnalyticsController@index  | api        |
|        | POST      | api/properties/{property}/analytics            | analytics.store  | App\Http\Controllers\API\AnalyticsController@store  | api        |
|        | PUT|PATCH | api/properties/{property}/analytics/{analytic} | analytics.update | App\Http\Controllers\API\AnalyticsController@update | api        |
|        | GET|HEAD  | api/summary                                    | summary.index    | App\Http\Controllers\API\SummaryController@index    | api        |
+--------+-----------+------------------------------------------------+------------------+-----------------------------------------------------+------------+
```

```
docker-compose run --rm artisan make:controller API/PropertiesController
docker-compose run --rm artisan make:controller API/AnalyticsController
docker-compose run --rm artisan make:controller API/SummaryController
docker-compose run --rm artisan make:test PropertiesTest
```

Created models and JSON resources

```
docker-compose run --rm artisan make:model Property
docker-compose run --rm artisan make:model AnalyticType
docker-compose run --rm artisan make:model Analytic
docker-compose run --rm artisan make:resource Analytic
docker-compose run --rm artisan make:resource AnalyticCollection
docker-compose run --rm artisan make:resource Property
docker-compose run --rm artisan make:resource SummaryCollection
```

Modified models with fillable properties, relations and had to change table name for Analytic

For Property model added id into hidden fields, as I assumed we only want to show guid to the frontend.

PropertiesController now implements method store, 
validation rules I pushed into the model itself, as they may be useful in multiple places  

Generated another test and implemented logic for storing, updating and listing analytics
```
docker-compose run --rm artisan make:test AnalyticsTest
```

