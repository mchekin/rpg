## Docker Development Environment

![](https://raw.githubusercontent.com/mchekin/rpg/f19c452aefcbd028c7db521bd50d1cec5995b137/public/images/locations/Fortress-300px.png)

### Table of Contents

1. [Requirements](#requirments)
2. [Installation](#installation)
4. [Using Admin Dashboard](#usingadmindashboard)

<a name="requirements"></a>
### Requirements
- [Docker & Docker Compose](https://www.docker.com/get-started)

<a name="installation"></a>
### Installation
- Clone the repo

        git clone https://github.com/mchekin/rpg.git game

- Navigate to the project folder

        cd game
        
- Create .env file from the .env.example file

        copy .env.docker.example .env
  
  On Windows:

        copy .env.docker.example .env

- Bring the containers up

        docker-compose up -d

- Navigate to [http://localhost:8080/](http://localhost/8080)

<a name="usingadmindashboard"></a>
### Using Admin Dashboard
[Voyager](https://laravelvoyager.com/) has been integrated into the project as an Admin Dashboard.

To use the Admin:

- Register a user in the application (You can skip this step if you already have a user).
- Give the user the admin role by running:

        docker-compose exec app php artisan voyager:admin <user email>
        
- Navigate to [http://localhost:8080/admin](http://localhost:8080/admin).
- Log in with the user credentials (If not logged in automatically).

Further information about using Voyager can be found on its [official website](https://laravelvoyager.com/).
