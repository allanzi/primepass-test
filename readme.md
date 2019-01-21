## Primepass Test
This project is a test of Full-stack developer job

## How to run app
- [Install Docker and docker-compose](https://gist.github.com/allanzi/419bf04e6ef02167007727913f6a435d)  
- Run Project:
    - `docker-compose up -d`
- In first time:
    - `docker exec -it primepass-app sh`
    - `composer install`
    - `php artisan migrate --seed`
    
## How to run tests
- `docker exec -it primepass-app sh`  
- `./vendor/bin/phpunit tests/`

## Routes:
| Method    | URI                  | Name         | Action                                      | Middleware |
| :-------- | :------------------- | :----------- | :------------------------------------------ | :--------- |
|  GET,HEAD  | api/user             | user.index   | App\Http\Controllers\UserController@index   | api        |
|  POST      | api/user             | user.store   | App\Http\Controllers\UserController@store   | api        |
|  GET,HEAD  | api/user/{user}      | user.show    | App\Http\Controllers\UserController@show    | api        |
|  PUT,PATCH | api/user/{user}      | user.update  | App\Http\Controllers\UserController@update  | api        |
|  DELETE    | api/user/{user}      | user.destroy | App\Http\Controllers\UserController@destroy | api        |