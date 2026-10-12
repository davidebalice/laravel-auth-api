# Laravel Auth API

Authentication API built with Laravel 9 and Laravel Passport, exposed both as a REST API and as a GraphQL API.
Users can register, log in with username and password, reset their password by email and access protected product data with an OAuth2 access token.

The frontend is available in a separate repository: [react-frontend-login-api](https://github.com/davidebalice/react-frontend-login-api).

## Features

- Registration and login with Laravel Passport access tokens
- Forgot password flow: a PIN code is sent by email and used to reset the password
- Protected endpoint to get the logged user
- Protected REST endpoints for products
- GraphQL API with [rebing/graphql-laravel](https://github.com/rebing/graphql-laravel): a public `login` mutation and protected `products` / `product` queries
- Request validation with Form Requests

## Tech stack

- [PHP 8](https://www.php.net/) and [Laravel 9](https://laravel.com/)
- [Laravel Passport](https://laravel.com/docs/passport) (OAuth2)
- [GraphQL for Laravel](https://github.com/rebing/graphql-laravel)
- [MySQL](https://www.mysql.com/)

## Getting started

### Requirements

- PHP 8.0.2 or later
- Composer
- MySQL

### Installation

```bash
git clone https://github.com/davidebalice/laravel-auth-api.git
cd laravel-auth-api
composer install
cp .env.example .env
php artisan key:generate
```

### Configuration

Set the database and mail settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=2525
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_FROM_ADDRESS="noreply@example.com"
```

Then run the migrations and create the Passport keys and clients:

```bash
php artisan migrate
php artisan passport:install
```

### Run

| Command             | Description                              |
| ------------------- | ---------------------------------------- |
| `php artisan serve` | Start the API on `http://localhost:8000` |
| `php artisan test`  | Run the tests                            |

## API endpoints

REST routes are prefixed with `/api`. Protected routes require the header `Authorization: Bearer <token>`.

| Method | Endpoint              | Description                                                       |
| ------ | --------------------- | ----------------------------------------------------------------- |
| POST   | `/api/register`       | Register a new user (`name`, `email`, `password`) and get a token |
| POST   | `/api/login`          | Log in with `username` and `password` and get a token             |
| POST   | `/api/forgetpassword` | Send a reset PIN code to the user email                           |
| POST   | `/api/resetpassword`  | Reset the password with `email`, `token` (PIN) and `password`     |
| GET    | `/api/user`           | Get the logged user (auth)                                        |
| GET    | `/api/products`       | List products (auth)                                              |
| GET    | `/api/products/{id}`  | Get a product (auth)                                              |

### GraphQL

| Method   | Endpoint          | Description                                                                  |
| -------- | ----------------- | ---------------------------------------------------------------------------- |
| POST     | `/graphql/public` | Public schema with the `login(username, password)` mutation, returns a token |
| GET/POST | `/graphql`        | Protected schema with the `products` and `product(id)` queries (auth)        |

Example:

```graphql
mutation {
  login(username: "user", password: "password")
}
```

```graphql
query {
  products
}
```

## Project structure

```text
app/
├── GraphQL/
│   ├── Mutations/      # Login mutation
│   └── Queries/        # Products and product queries
├── Http/
│   ├── Controllers/    # Auth, password reset, user and product controllers
│   └── Requests/       # Validation rules
├── Mail/               # Password reset email
└── Models/             # User and Product
routes/api.php          # REST routes
config/graphql.php      # GraphQL schemas
```

## Author

**Davide Balice** – [davidebalice.dev](https://www.davidebalice.dev)
