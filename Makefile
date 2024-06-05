# Makefile for Docker Nginx PHP Composer MySQL

include .env

# MySQL
MYSQL_DUMPS_DIR=data/db/dumps


.DEFAULT_GOAL=help
WWW_USER_ID=${shell id -u}
PHP_CONTAINER=$(shell docker compose ps -q php 2> /dev/null)
MYSQL_CONTAINER=$(shell docker compose ps -q mysqldb 2> /dev/null)

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  init 	      		 Install the project"
	@echo "  start 	      		 Start the docker containers"
	@echo "  down 	      		 Stop the docker server and remove containers"
	@echo "  build 	      		 Rebuild the containers"
	@echo "  clean               Clean directories for reset"
	@echo "  composer            Install composer dependencies"
	@echo "  logs                Follow log output"
	@echo "  mysql-dump          Create backup of all databases"
	@echo "  mysql-restore       Restore backup of all databases"
	@echo "  test                Run test suit"

init:
	rsync --ignore-existing web/.env.example web/.env
	@make -s build
	@make -s start
	@make -s composer
	@docker compose exec php bash -c "php artisan key:generate"
	@docker compose exec php bash -c "php artisan migrate:fresh --seed"
	@docker compose exec php bash -c "php artisan storage:link"

start:
	@WWW_USER_ID=${WWW_USER_ID} docker compose up --pull missing --remove-orphans -d

down:
	@docker compose down

build:
	@docker compose --profile test build --parallel


clean:
	@rm -Rf data/db/mysql/*
	@rm -Rf $(MYSQL_DUMPS_DIR)/*
	@rm -Rf web/app/vendor
	@rm -Rf web/app/composer.lock
	@rm -Rf web/app/doc
	@rm -Rf web/app/report
	@rm -Rf etc/ssl/*

composer:
	@docker exec -it ${PHP_CONTAINER} bash -c "composer install"

logs:
	@docker-compose logs -f

test:
	@docker compose exec php bash -c "php artisan view:clear"
	@docker compose run php bash -c "composer test"

test-coverage:
	@docker compose exec php bash -c "php artisan view:clear"
	@docker compose run php bash -c "composer test-coverage"
