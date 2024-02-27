<a name="readme-top"></a>

<!-- Project name -->
<h1 align="center">
    User management system
</h1>
<p align="center">
    Test project for Thiio
</p>

<!-- Table of contents -->
<details>
    <summary>
        Table of Contents
    </summary>
    <ol>
        <li>
            <a href="#about-the-project">
                About the project
            </a>
            <ul>
                <li>
                    <a href="#built-with">
                        Built with
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#getting-started">
                Getting started
            </a>
            <ul>
                <li>
                    <a href="#prerequisites">
                        Prerequisites
                    </a>
                </li>
                <li>
                    <a href="#installation">
                        Installation
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#usage">
                Usage
            </a>
            <ul>
                <li>
                    <a href="#register">
                        Register
                    </a>
                </li>
                <li>
                    <a href="#login">
                        Login
                    </a>
                </li>
                <li>
                    <a href="#create-user">
                        Users list
                    </a>
                </li>
                <li>
                    <a href="#search-user">
                        Search user
                    </a>
                </li>
                <li>
                    <a href="#show-user">
                        Show user
                    </a>
                </li>
                <li>
                    <a href="#create-user">
                        Create user
                    </a>
                </li>
                <li>
                    <a href="#update-user">
                        Update user
                    </a>
                </li>
                <li>
                    <a href="#delete-user">
                        Delete user
                    </a>
                </li>
                <li>
                    <a href="#logout">
                        Logout
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#tests">
                Tests
            </a>
        </li>
    </ol>
</details>

<!-- About the project -->
## About the project

![Project Screenshot][project-screenshot]

This a simple yet robust web application that allows for managing user accounts. This includes functionalities for user registration, login, viewing, editing, and deleting user profiles.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- Built with -->
### Built with

This project was built with the next frameworks / libraries:

#### Backend

* [Laravel](https://laravel.com)

#### Frontend
* [Vite](https://vitejs.dev)
* [Vue.js](https://vuejs.org)
* [Vuetify](https://vuetifyjs.com/en)
* [TypeScript](https://www.typescriptlang.org)

#### Database
* [MySQL](https://www.mysql.com)

#### Authentication
* [JWT-Auth](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)

#### TDD Framework
* [PHPUnit](https://phpunit.de/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- Getting started -->
## Getting started

To get a local copy up and running follow these simple steps.

### Prerequisites
In order to run this project you need the following:
```bash
php ^8.1
```
```bash
node ^18.0
```
```bash
mysql
```

### Installation

Clone the repo
   ```bash
   $ git clone https://github.com/Julio0971/thiio
   ```

#### Api setup

1. Install composer dependencies
   ```bash
   $ cd api
   $ composer install
   ```
2. Copy the .env file configuration
   ```bash
   $ cp .env.example .env
   ```
3. Create a new project key
   ```bash
   $ php artisan key:generate
   ```
4. Generate secret key
   ```bash
   $ php artisan jwt:secret
   ```
5. Make a new database
   ```sql
   mysql> CREATE DATABASE thiio;
   ```
6. Enter your database credentials to .env file
   ```plain
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=thiio
    DB_USERNAME=root
    DB_PASSWORD=password
   ```
7. Run migrations and seeders
    ```bash
    $ php artisan migrate --seed
    ```

#### App setup

1. Install NPM packages
    ```bash
   $ cd app
   $ npm install
   ```
2. Make the `.env.development.local` file configuration
   ```bash
   $ touch .env.development.local
   ```
3. Add the following variable to `.env.development.local` file configuration
   ```js
   VITE_API_URL=http://localhost:8000/api
   ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- Usage -->
## Usage

Start the project

1. Start api serve
    ```bash
    $ php artisan serve --host=localhost
    ```
2. Start app
    ```bash
    $ npm run dev
    ```
3. Navigate to http://localhost:5173
4. The following view should appear
![Start project Screenshot][start-project-screenshot]

### Register
1. Click in register on the right top
2. Fill all fields in register form with your data
3. Rules:
    * Name: Required
    * Username: Required, min length: 3
    * Password: Required, min length: 8
    * Password confirmation: Required, must be the same as password field
4. Click in register button
![Register Screenshot][register-screenshot]

### Login
1. Click in login on the right top
2. Fill the fields as follow to enter the project with the initial user
    * Username: user_test
    * Password: password
3. Click in login button
![Login Screenshot][login-screenshot]

### Users list
1. Following the register or login steps above will show the users list
2. You can click on pagination below the table in order to navigate the list
![User list Screenshot][users-list-screenshot]

### Search user
1. Write a name or an username in the search field on the right top to search a user.
2. No need to click anything, the search is made automatically after the writing.
![Search user Screenshot][search-user-screenshot]

### Show user
1. On the users list click in eye icon of any user you wish
2. A modal dialog with the user info will appear
4. Click in close to close the modal dialog
![Show user Screenshot][show-user-screenshot]

### Create user
1. On the left top click in NEW USER
2. A modal dialog with the user form will appear
3. Fill all field with data following the next rules
4. Rules:
    * Name: Required
    * Username: Required, min length: 3
    * Password: Required, min length: 8
    * Password confirmation: Required, must be the same as password field
5. Click in save to create the user
6. Or click in close to close the modal dialog
![New user Screenshot][new-user-screenshot]

### Update user
1. On the users list click in edit icon of any user you wish
2. A modal dialog with the user form will appear
3. Fill the field with data following the next rules
4. Rules:
    * Name: Required
    * Username: Required, min length: 3
    * Password: Optional, min length if anything is written: 8
    * Password confirmation: Optional, must be the same as password field
5. Click in update
6. Or click in close to close the modal dialog
![Update user Screenshot][update-user-screenshot]

### Delete user
1. On the users list click in trash icon of any user you wish
2. A confirmation modal dialog will appear
3. If you wish to delete the user click in confirm
4. Otherwise click in close to cancel the deletion
![Delete user Screenshot][delete-user-screenshot]

### Logout
1. On the right top click in your name
2. A menu will appear with the option of logout
3. If you wish to close the current session, click in logout and the login view will appear
4. Otherwise click outside the menu to close it
![Logout Screenshot][logout-screenshot]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Tests

There are two test files in the backend:
```plain
api/tests/Feature/UserTest.php
```
```plain
api/tests/Feature/AuthTest.php
```

In order to run the api tests follow the next steps:

1. Navigate to api
```bash
$ cd api
```
2. Execute the tests
```bash
$ php artisan test
```

![Tests Screenshot][tests-screenshot]

<!-- Markdown images -->
[project-screenshot]: images/project-screenshot.png
[start-project-screenshot]: images/start-project.png
[tests-screenshot]: images/tests.png
[register-screenshot]: images/register.png
[login-screenshot]: images/login.png
[users-list-screenshot]: images/users-list.png
[new-user-screenshot]: images/new-user.png
[update-user-screenshot]: images/update-user.png
[search-user-screenshot]: images/search-user.png
[show-user-screenshot]: images/show-user.png
[delete-user-screenshot]: images/delete-user.png
[logout-screenshot]: images/logout.png