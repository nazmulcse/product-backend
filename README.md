# Simple Product CRUD api example with Laravel 8 and JWT
Product-Backend

### Requirements
    PHP >= 5.3
    MySQL

## Installation

1. Clone the the repository
    ```
    git clone https://github.com/nazmulcse/product-backend.git
    ```

2. Navigate to your project directory and run
    ```
    composer install
    npm install
    php -r "file_exists('.env') || copy('.env.example', '.env');"
    php artisan key:generate
    php artisan migrate
    php artisan jwt:secret
    php artisan storage:link
    ```

## Usage

1. Start your project
    ```
    php artisan serve
    ```


### Via Docker

1. Start the docker's containers
    ```
    docker-compose up -d
    ```
2. Set DB credentials in ```.env``` file as follows:
    ```
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel_jwtauth
    DB_USERNAME=root
    DB_PASSWORD=
    ```

3. Run following composer and artisan command
    ```
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan jwt:secret
    docker-compose exec app php artisan storage:link
    docker-compose exec app php artisan migrate
    ```

4. Project will run in 8080 port. To run in another port, change port in ```docker-compose.yml``` file

##Author

[Nazmul Hasan]