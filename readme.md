## Online Role Playing Game

![](https://raw.githubusercontent.com/mchekin/rpg/f19c452aefcbd028c7db521bd50d1cec5995b137/public/images/locations/Blacksmith-300px.png)

![](https://travis-ci.org/mchekin/rpg.svg)

### Table of Contents

1. [Requirements](#requirments)
2. [Installation](#installation)
3. [Running in local environment](#runningindevelopmentenvironment)
4. [License](#license)

<a name="requirements"></a>
### Requirements (for local development)

- PHP 7.0.0 or Higher
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)
- [SQLite](https://www.sqlite.org/)

<a name="installation"></a>
### Installation
- Clone the repo

        git clone https://github.com/mchekin/rpg.git game

- Navigate to the project folder

        cd game

- Run composer install to import the dependencies and enable auto-loading

        composer install

- Create .env file from the .env.example file

        cp .env.example .env
  
  On Windows:
  
        copy .env.example .env

- Generate Laravel Application key

        php artisan key:generate

- Create SQLite database file

        touch database/database.sqlite
  
  On Windows:
  
        copy NUL database\database.sqlite

- Run Laravel database migrations and seeds

        php artisan migrate --seed

<a name="runningindevelopmentenvironment"></a>
### Running in local environment

- Run PHP build-in development server on the host machine

        php artisan serve  

- Navigate to [http://localhost:8000/](http://localhost:8000/)

<a name="license"></a>
### License
Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)