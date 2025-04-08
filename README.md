<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# RSS Parser API

This project is a Laravel-based API for parsing RSS feeds,
with full CRUD functionality and auto-generated API documentation using Swagger UI.


## Technologies Used

- PHP 8.x + Laravel
- MySQL 8
- Docker + Docker Compose
- Swagger (OpenAPI) for API docs
- Artisan Command for RSS parsing

## Getting Started 

> Make sure you have [Docker Desktop](https://www.docker.com/products/docker-desktop) installed before proceeding.

### 1. Clone the Repository

bash
git clone https://github.com/your-username/rss-parser.git
cd rss-parser

## Create the .env File
cp .env.example .env

###  Start the Application
make up or docker-compose up -d --build

### Generate App Key and Run Migrations
make key
make migrate

### Or manually
docker exec -it laravel_app bash
php artisan key:generate
php artisan migrate


### Run the RSS Parser
php artisan rss:parse

### Swagger API Documentation
http://localhost:8000/api/documentation

### It includes all API endpoints (GET, POST, PUT, DELETE) for managing posts.
### To regenerate the documentation manually:
make swagger

### Makefile Commands
make up         # Start Docker containers
make down       # Stop all containers
make restart    # Restart the stack
make migrate    # Run Laravel DB migrations
make swagger    # Generate Swagger docs
make bash       # Enter Laravel container shell

### Project structure

.
├── app/              # Application logic (models, controllers)
├── routes/           # API route definitions
├── database/         # Migrations & seeders
├── docker-compose.yml
├── Dockerfile
├── .env.example
├── Makefile
└── README.md
