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

- Create .env file from the .env.example file

        cp .env.example .env
  
  On Windows:
  
        copy .env.example .env

- Run composer install to import the dependencies and enable auto-loading

        composer install

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

- Enable Laravel Task Scheduling

    1. Open the cron tab file
    
            crontab -e
            
    2. Add the following line and save
            
            * * * * * php <path-to-project>/artisan schedule:run >> /dev/null 2>&1
  
  On Windows:
  
  Open the Terminal as Administrator, navigate to the project's root folder and run:
    
        schtasks /create /sc minute /mo 1 /tn "RPG SCHEDULER" /tr %cd%\scheduler.bat
        
    To disable the annoying command-line pop-up each time the task runs:
    
    1. Open Windows "Run" dialog by pressing "Windows Key + r"
    2. Enter type "Taskschd.msc" and press Enter. This will open the "Task Scheduler".
    3. In Task Scheduler's "Active Tasks" section find the "RPG SCHEDULER" task and double-click it.
    4. In the left "Actions" panel click "Properties". This will open "Properties" pop-up.
    5. In the pop-up select the "Run whether user is logged in or not" and press Enter.
    You maybe asked for your Windows user's password to complete the process.
        
  To remove the scheduled task you can use
  
        schtasks /delete /tn "RPG SCHEDULER" /f

<a name="license"></a>
### License
Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)