.DEFAULT_GOAL := help

HOST ?= 0.0.0.0

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
## Darkmira Community Event Manager
## --------------------------------
##

##
## Setup
## -----
##

install: .env run initialize info ## Install and start the project

.env: .env.dist
	@if [ -f .env ]; then \
		echo '\033[1;41mYour .env file may be outdated because .env.dist has changed.\033[0m';\
		echo '\033[1;41mCheck your .env file, or run this command again to ignore.\033[0m';\
		touch .env;\
		exit 1;\
	else\
		echo cp .env.dist .env;\
		cp .env.dist .env;\
	fi

initialize: run bucket
	docker-compose run composer install
	docker-compose exec php bash -c "php bin/console doctrine:migrations:migrate --no-interaction"
	docker-compose exec php bash -c "php bin/console doctrine:fixtures:load --no-interaction"

run: .env behat.yml
	docker-compose up -d

bucket:
	docker run --network container:`docker-compose ps -q storage` \
	           --entrypoint="" \
	           -v `pwd`:/app \
	           -w /app \
	           minio/mc:RELEASE.2019-09-24T01-36-20Z \
	           /bin/sh -c "chmod +x ./docker/minio/create-bucket.sh && ./docker/minio/create-bucket.sh"

##
## Tests
## -----
##

test: phpunit behat check_migrations_updated ## Run all tests stack

phpunit: ## Run unit tests
	docker-compose run composer ./vendor/bin/simple-phpunit

behat: ## Run functional tests
	docker-compose run php vendor/bin/behat

cs: ## Executes php cs fixer
	docker-compose exec php vendor/bin/php-cs-fixer --no-interaction --diff -v fix

check_migrations_updated:
	@if docker-compose exec php bin/console doctrine:schema:update --dump-sql | grep "Nothing to update"; then \
		echo "OK, Schema is up to date with schema mapping."; \
	else \
		echo "Migrations are not up to date with schema mapping."; \
		echo "Here are SQL missing in migrations:"; \
		docker-compose exec php bin/console doctrine:schema:update --dump-sql; \
		return false; \
	fi

behat.yml: behat.yml.dist
	@if [ -f behat.yml ]; then \
		echo '\033[1;41mYour behat.yml file may be outdated because behat.yml.dist has changed.\033[0m';\
		echo '\033[1;41mCheck your behat.yml file, or run this command again to ignore.\033[0m';\
		touch behat.yml;\
		exit 1;\
	else\
		echo cp behat.yml.dist behat.yml;\
		cp behat.yml.dist behat.yml;\
	fi

##
## Tools
## -----
##

logs: ## Show logs
	docker-compose logs -ft

bash: ## Bash into php container
	docker-compose up -d php
	docker-compose exec php bash

info: ## Show useful urls
	@echo ""
	@echo "\033[92m[OK] Application running on http://$(HOST):8080\033[0m"
	@echo "\033[92m[OK] Minio running on http://$(HOST):9001\033[0m"
	@echo "\033[92m[OK] Mailhog running on http://$(HOST):8025\033[0m"
	@echo ""
	@echo "Development users:"
	@echo ""
	@echo "  admin: admin@test.com / adminpass"
	@echo "  user:  user@test.com  / userpass"
	@echo ""

##
##
