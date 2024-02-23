# Task Management Application API

### Introduction
    This is a simple Task Management App API built using PHP (Laravel) and Mysql. It allows users to create, update, delete, and view tasks

### Features
- User Authentication: A login mechanism to authenticate users.

- Task Listing: Retrieve a list of tasks, filterable by status, date, and assigned user. Functionalities for creating,       updating, and deleting tasks are implemented.

- Task Assignment: Allow the assignment of multiple users to a task. Provide the ability to unassign a user from a task, and allow users to change the status of a task.

- User-Specific Task Lists: Provide a list of tasks assigned to a particular user and display a list of tasks assigned to the currently logged-in user

#### Setup

1. Clone the repository: 
    git clone https://github.com/tamilarasana/New-Task.git

2. Navigate to the project directory:
    cd task-management-app

3. Install dependencies:
    composer install

4. Set up environment variables:

- Copy the .env.example file to .env:
    cp .env.example .env

- Generate a new application key:
    php artisan key:generate

- Set up your database in the .env file
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

5. Run migrations
- php artisan migrate 

6. Seed the database with dummy data
- php artisan db:seed

7. Import the provided Postman collection file.
    Inside the project one folder is there PostmanApi Download and import the postman

8. Run the development server
- php artisan migrate
    



