# Introduction

The goal of this application is to create an API that translates the commands sent from Earth to instructions understood by a rover which is exploring the surface of Mars. The surface is sprinkled of obstacles which can prevent the movements of the rover.

### Mars Surface projection

Mars is thought as a sphere. It's surface is projected to a bidimensional grid of `M` meridians and `P` parallels, by using the Mercator's modified centrographic cylindrical projection. In this representation:
- The origin (`0, 0`) is set at the top left corner for convenience
- The right bottom corner is the point with coordinates `(x,y) = (M-1, P-1)`
- Points laying on the right border of the grid correspond to the points at the left border of the grid
- Points laying on the top border of the grid are a unique point (North Pole) 
- Points laying on the bottom border of the grid are a unique point (South Pole) 
- To each meridian corresponds an antimeridian, which is a meridian at 180° from the considered meridian
- When we are at the right border and move right, we come out at the left border, going right on the same parallel
- When we are at the left border and move left, we come out at the right border, going left on the same parallel
- When we are at the top border and move up, we come out at the top border, going down on the antimeridian of the original meridian
- When we are at the bottom border and move down, we come out at the bottom border, going up on the antimeridian of the original meridian

### Rover capabilities

The Mars rover has the following capabilities:

- Receive the initial starting point (`x,y`) and the direction (`N,S,E,W`) it is facing
- Move forward and backward (`f,b`) over the bidimensional grid
- Turn left and right (`l,r`) 90° on itself
- Receive list of commands to execute: the execution lasts until the command list is completed, or an obstacle is found. In this case, the rover moves up to the last possible point, aborts the sequence and reports the obstacle
- Implement wrapping of the planet: starting from the current position, move forward until the circumnavigation of the planet is complete, or when an obstacle is found on the surface. The obstacle management is performed as in the previous point


# Installation

The installation process explained below is thought for Windows10 operating system. 
You can use similar procedures for Unix operating systems, or even better by using Docker.
- Download and install and run [XAMPP](https://www.apachefriends.org/it/download.html): runs an Apache server with PHP and MySQL 
- Download and install [Composer](https://getcomposer.org/): this is a package manager for PHP applications
- Install [Laravel](https://laravel.com/docs/11.x/installation): `composer global require laravel/installer`
- Download and install [Postman](https://www.postman.com/downloads/): allows to perform HTTP requests on localhost
- Define Postman environment variable `MarsRoverApi: http://127.0.0.1:8000/api/v1`
- Clone the `mars-rover` repository on localhost
- Move to the repository folder
- Rename `.env.example` to `.env`: this file contains configuration settings and credentials used by the application, stored as environment variables. Usually this file is excluded from repository for security reasons, here is committed only for testing purposes
- Configure database connection parameters in `.env`
- Configure `total_parallels`, `total_meridians`, `total_obstacles` in `config/app.php` 
- Run `composer install`: installs all the dependencies needed from the application
- Run `php artisan migrate`: creates the database structure by running the migrations
- `php artisan db:seed --class=UserSeeder`: insert a fake user in users table
- `php artisan db:seed --class=ObstacleSeeder`: creates a random list of obstacles placed in the Mars surface
- `php artisan key:generate`: generates a unique application key
- `php artisan serve`: starts the Laravel server on localhost
- Visit [Laravel index page](http://127.0.0.1:8000/): if you see the welcome page, everything is working fine! 🚀 

# Requirements

The application needs a list minimum requirements to work correctly:

- PHP 8.2 or higher
- Laravel 11 or higher
- MariaDB 10.4 or higher

# Usage

The application exposes various APIs to perform operations on Mars rover. 
The Postman collection to perform the invocations is provided for convenience in the `postman` folder.
Let's explore the defined API endpoints with come examples.

### setPosition
The goal of this API is to set the Mars rover position on the grid. 
If an obstacle is present on the required position, the operation doesn't succeed.

**Verb**
 `POST`

**URL**
 `/api/v1/marsrover/setPosition/`

**Body**

    {
      "x": 1,
      "y": 20,
      "direction": "N"
	}
**Response (success)**

    {
      "success": true
    }
**Response (error)**

    {
      "success": false
    }

<br/>

### sendCommands
The goal of this API is to send a list of commands the Mars rover. Commands may move forward and backward (`f,b`), turn left and right (`l,r`) the rover. The execution lasts until the command list is completed, or an obstacle is found. In both cases, the history of commands performed is returned, and the success/failure for each command is reported. 
If this is the first endpoint invoked, before running the API it's required to set the initial position of the rover, otherwise an error is returned.

**Verb**
 `POST`

**URL**
 `/api/v1/marsrover/sendCommands/`

**Body**

    {
      "commands": [
        "f"
      ]
	}
**Response (success)**

    [
      {
        "command": {
          "name": "MOVE_FORWARD",
          "value": "f"
        },
        "position": {
          "x": 10,
          "y": 0,
          "direction": {
            "name": "NORTH",
            "value": "N"
          }
        },
        "success": true
      }
    ]
**Response (error)**

    [
      {
        "command": {
          "name": "MOVE_FORWARD",
          "value": "f"
        },
        "position": {
          "x": 10,
          "y": 0,
          "direction": {
            "name": "NORTH",
            "value": "N"
          }
        },
        "success": false
      }
    ]
<br/>


### wrap
The goal of this API is to perform wrapping of the planet: starting from the current position, move forward until the circumnavigation of the planet is complete, or when an obstacle is found on the surface. In this case, the rover moves up to the last possible point, aborts the sequence and reports the obstacle. In both cases, the history of commands performed is returned, and the success/failure for each command is reported. 
If this is the first endpoint invoked, before running the API it's required to set the initial position of the rover, otherwise an error is returned.

**Verb**
 `POST`

**URL**
 `/api/v1/marsrover/wrap/`

**Body**

    (empty)
	
**Response (success)**

    [
      {
        "command": {
          "name": "MOVE_FORWARD",
          "value": "f"
        },
        "position": {
          "x": 10,
          "y": 0,
          "direction": {
            "name": "NORTH",
            "value": "N"
          }
        },
        "success": true
      },
      
      [...]
    ]
**Response (error)**

    [
	  [...], 
	  
      {
        "command": {
          "name": "MOVE_FORWARD",
          "value": "f"
        },
        "position": {
          "x": 10,
          "y": 0,
          "direction": {
            "name": "NORTH",
            "value": "N"
          }
        },
        "success": false
      }
    ]

# Technical notes

The application is developed in PHP, using Laravel framework. Laravel has been chosen because provides very handy built-in functionalities to manage API routes, validate requests, handle authentication, create classes, perform tests, resolve dependencies, abstract database, seed tables, manage migrations.

### Data flow
When an API endpoint is invoked, its request is first validated (following some validation rules), to ensure that body is correct. If the request is correct, the controller addressed from the API routing is called.  At the moment we have only `MarsRoverController`.<br/> 
The controller resolves the `MarsRoverControlSystemInterface`, which is an entity that handles the commands sent to the rover. This translates the commands received to basic commands (move forward, move backward, rotate left, rotate right) executed from the rover.<br/> 
When commands are translated, the `MarsRoverInterface` is resolved and the rover instance is created. On creation, rover tries to retrieve the last successful position (if any). If no positions are available, it's required to set rover initial position.<br/>
Now it's time to run the required command. If the command succeeds, the rover persists the last position by using the `PositionRepository`. At the moment, data storage is database, but since we are using a repository we have decoupled this dependency.<br/> 
When the command is executed, the result is returned and reported to the caller as an HTTP response.


### Architecture
The application has the following architecture:

- **ApplicationLogic**: contains all the application logic classes (like Mars rover)
- **Data**: contains all the data used from the application logic
- **Enums**: contains the enums used from the application
- **Http**: contains the API controllers and related requests
- **Models**: contains the models which represent data on database
- **Providers**: contains the providers used to register and resolve dependencies
- **Repositories**: contains the list of repositories, allows to abstract the data storage


### Database structure
The application relies on data stored on database, with the following tables:

 - **positions**: contains the list of successful positions (coordinates and direction) of the rover
 - **obstacles**: contains the list of obstacles in the grid (coordinates), created randomly during the installation


### Tests

The application is provided with unit and feature tests, to guarantee the quality of the code. 
At the moment, we have a coverage **over 98%**, with a 100% on most important application logic classes (i.e. rover).


### Next steps
There are some actions we can perform to improve the current implementation:

- **Use Docker**: move the infrastructure (web server, PHP installation, database engine, Laravel) to Docker, to avoid efforts to install all of them to run the application
-  **Add authentication**: we don't want that some joker from Earth may send commands to the rover. For this reason, we need to implement an authentication mechanism, API request are accepted only if provided with a valid Authentication header with a JWT generated from the app or an Authentication Server (Oauth 2.0)
- **Return history**: create an API that returns the complete history of commands executed successfully from the rover
- **Store errors**: the rover doesn't prior know the distribution of obstacles. It could be interesting to store the list of obstacles found and to return them on request
