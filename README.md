# Introduction

The goal of this application is to create an API that translates the commands sent from Earth to instructions understood by a rover which is exploring the surface of Mars. The rover has the following capabilities:

- Receive the initial starting point (`x,y`) and the direction (`N,S,E,W`) it is facing;
- Move forward and backward (`f,b`);
- Turn left and right (`l,r`);
- Receive list of commands to execute: the execution lasts until the list is completed, or when an obstacle is found. In this case, the rover moves up to the last possible point, aborts the sequence and reports the obstacle;
- Implement wrapping of the planet: starting from the current position, move forward until the circumnavigation of the planet is complete, or when an obstacle is found on the surface. The obstacle management is performed as in the previous point;

The Mars surface is projected to a bidimensional grid, by using the Mercator's modified centrographic cylindrical projection. The planet is divided into a grid of `N` meridians (each meridian has a corresponding anti-meridian), and `M` parallels. In this representation:
- The origin (`0,0`) is set at the top left corner for convenience
- All points at the right border of the grid (with `x = (N-1)`) are the same points at the left border of the grid (with  `x = 0`)
- All points at the top border of the grid (with  `y = 0`) are a unique point (North Pole) 
- All points at the top border of the grid (with `y = (M-1)`) are a unique point (South Pole) 



# Installation

- Install [XAMPP](https://www.apachefriends.org/it/download.html) 
- Install [Composer](https://getcomposer.org/)
- Install [Laravel](https://laravel.com/docs/11.x/installation)
- Download and install [Postman](https://www.postman.com/downloads/)
- Define Postman environment variable MarsRoverApi = http://127.0.0.1:8000/api/v1
- Rename .env.example to .env
- Configure database connection parameters in .env
- cd mars-rover
composer install
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ObstacleSeeder
php artisan key:generate
php artisan serve
