# Task Management System

A Laravel-based Task Management System designed to manage employees, assign tasks, track task progress, and monitor user activities through an admin dashboard.

# Features

# Role-Based Access Control
- Admin
- Team Leader
- Employee

#Employee Management
- Add employees
- Edit employee details
- Delete employees
- Manage employee accounts
  
# Task Management
- Create and assign tasks to employees
- Update and delete tasks
- Set task start dates and due dates
- Manage task priorities
- Track task statuses
  
# Task Priorities
- Low
- Medium
- High
- Urgent

# Task Status
- Pending
- In Progress
- Completed
- Cancelled

# Dashboard Statistics
- Total Employees
- Total Tasks
- Completed Tasks
- Pending Tasks
- High Priority Tasks
  
# Activity Logs
- Track employee and task activities
- Record created, updated, and deleted actions
- Monitor task status changes
- Activity logs accessible to Admin only

# Additional Features
- Role-based permissions
- Server-side DataTables
- Form validation
- Responsive Bootstrap interface

# Technologies Used
- PHP
- Laravel
- MySQL
- Bootstrap
- JavaScript
- jQuery
- jQuery Validation
- Yajra DataTables
- Spatie Laravel Permission

# Requirements

Make sure the following software is installed on your system:

PHP 8.2 or higher (depending on your Laravel version)
Composer
MySQL
Node.js and NPM
Git
Installation and Setup

Follow these steps to run the project locally.

1. Clone the Repository
bash
git clone [https://github.com/YOUR-USERNAME/YOUR-REPOSITORY.git](https://github.com/dishamakati/task_management_system_practical.git)


Navigate to the project directory:

bash
cd YOUR-REPOSITORY

2. Install PHP Dependencies
bash
composer install

3. Configure Environment File

Copy the example environment file:

bash
cp .env.example .env


For Windows PowerShell, you can use:

powershell
Copy-Item .env.example .env

4. Generate Application Key
bash
php artisan key:generate

5. Configure Database

Open the .env file and update your database configuration:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=


Create a MySQL database named:

text
task_management


Make sure your MySQL server is running.

6. Run Database Migrations
bash
php artisan migrate


If the project includes database seeders, run:

bash
php artisan db:seed

7. Install Frontend Dependencies
bash
npm install


Build frontend assets:

bash
npm run build

8. Start the Laravel Development Server
bash
php artisan serve


Open your browser and visit:

text
http://127.0.0.1:8000

Role Permissions

The application supports three user roles:

Role	Permissions
Admin	Manage employees, view all tasks, manage tasks, view dashboard and activity logs
Team Leader	Create, assign, update, and manage their own tasks
Employee	View assigned tasks and update task status

Clear application cache:

bash
php artisan optimize:clear


Run migrations:

bash
php artisan migrate


Run database seeders:

bash
php artisan db:seed


Start development server:

bash
php artisan serve
