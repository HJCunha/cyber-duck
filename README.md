# Cyber Duck
#### Hugo Cunha's Laravel project
Laravel Project for cyber-duck

- cp env.example .env
- touch storage/duck.sqlite
- composer install
- php artisan migrate:install
- php artisan migrate
- php artisan db:seed
- npm install
- npm run dev
- php artisan storage:link
- php artisan serve --port=8100

## Versions
- NPM: 4.2.0
- Laravel Framework: 5.7.21  
- PHP: 7.2.12
- Composer version 1.6.3


## Requested tasks

* Use https://adminlte.io/ as a framework for the application
* Basic Laravel Auth: ability to log in as administrator
* Use database seeds to create first user with email admin@admin.com and password “password”
* CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
* Companies DB table consists of these fields: Name (required), email, logo (minimum 100x100), website
* Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone
* Use database migrations to create those schemas above
* Store companies’ logos in storage/app/public folder and make them accessible from public
* Use basic Laravel resource controllers with default methods – index, create, store etc.
* Use Laravel’s validation function, using Request classes
* Use Laravel’s pagination for showing Companies/Employees list, -% entries per page
* Use Laravel make:auth as default Bootstrap-based design theme, but remove ability to register