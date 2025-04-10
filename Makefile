# Makefile for Laravel and Docker project

up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	make down
	make up

logs:
	docker-compose logs -f

bash:
	docker exec -it laravel_app bash

mysql:
	docker exec -it mysql_db bash

migrate:
	docker exec -it laravel_app php artisan migrate

seed:
	docker exec -it laravel_app php artisan db:seed

key:
	docker exec -it laravel_app php artisan key:generate

swagger:
	docker exec -it laravel_app php artisan l5-swagger:generate
