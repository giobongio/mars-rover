# Introduction

The goal of this application is to create an API that translates the commands sent from Earth to instructions understood by a rover which is exploring the surface of Mars. 

## Mars Surface projection

Mars is thought as a sphere. It's surface is projected to a bidimensional grid, by using the Mercator's modified centrographic cylindrical projection. The planet is divided into a grid of `N` meridians and `M` parallels. In this representation:
- The origin (`0,0`) is set at the top left corner for convenience
- All points at the right border of the grid (with `x = (N-1)`) are the same points at the left border of the grid (with  `x = 0`)
- All points at the top border of the grid (with  `y = 0`) are a unique point (North Pole) 
- All points at the top border of the grid (with `y = (M-1)`) are a unique point (South Pole) 

## Rover capabilities

The Mars rover has the following capabilities:

- Receive the initial starting point (`x,y`) and the direction (`N,S,E,W`) it is facing;
- Move forward and backward (`f,b`);
- Turn left and right (`l,r`);
- Receive list of commands to execute: the execution lasts until the list is completed, or when an obstacle is found. In this case, the rover moves up to the last possible point, aborts the sequence and reports the obstacle;
- Implement wrapping of the planet: starting from the current position, move forward until the circumnavigation of the planet is complete, or when an obstacle is found on the surface. The obstacle management is performed as in the previous point;


# Installation

The installation process explained below is thought for Windows10 operating system. 
You can use similar procedures for Unix operating systems, or even better by using Docker.
- Download and install and run [XAMPP](https://www.apachefriends.org/it/download.html) 
- Download and install [Composer](https://getcomposer.org/)
- Install [Laravel](https://laravel.com/docs/11.x/installation): `composer global require laravel/installer`
- Download and install [Postman](https://www.postman.com/downloads/)
- Define Postman environment variable `MarsRoverApi: http://127.0.0.1:8000/api/v1`
- Clone the `mars-rover` repository on localhost
- Move to the repository folder
- Rename `.env.example` to `.env`: this file contains configuration settings and credentials used by the application, stored as environment variables. Usually this file is excluded from repository for security reasons, here is committed only for testing purposes
- Configure database connection parameters in `.env`
- Run `composer install`: installs all the dependencies needed from the application
- Run `php artisan migrate`: creates the database structure by running the migrations
- `php artisan db:seed --class=UserSeeder`: insert a fake user in users table
- `php artisan db:seed --class=ObstacleSeeder`: creates a random list of obstacles placed in the Mars surface
- `php artisan key:generate`: generates a unique application key
- `php artisan serve`: starts the Laravel server on localhost
- Visit http://127.0.0.1:8000/: if you see the Laravel welcome page, everything is working fine! 🚀 

# Usage

Todo.

# Technical notes

Todo.

# Requirements

Todo.

# Next steps

Todo.
