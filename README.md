<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

Our Hangout is a blog website that is tailored towards places of entertainment in Singapore.
I made this website to act as a central hub of information regarding the places of entertainment in Singapore.

#### Some places of entertainment include but are not limited to:

-   Restaurants
-   Shopping malls
-   Exhibitions
-   Outdoor areas
-   Activity areas

## How to run

### First, connect the backend to your MySQL.

1. Create a MySQL Schema and remember the name of the DB.
2. Copy and change the .env.example to a .env file
3. Configure your DB connection under the _DB_ section
    1. Add your DB Schema name to DB_DATABASE
    2. if you haven't changed any default MySQL settings then you can simple add your username and password under DB_USERNAME and DB_PASSWORD.

### Second, clone the project and run it!

```
> cd our-hangout-backend
> php artisan migrate:fresh --seed
> php artisan serve
```

#### Now, you can access the api by "http://localhost:8000/api/$route_name"
