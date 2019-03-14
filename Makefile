.DEFAULT_GOAL := help

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
	           minio/mc \
	           /bin/sh -c "chmod +x ./docker/minio/create-bucket.sh && ./docker/minio/create-bucket.sh"

##
## Tests
## -----
##

test: ## Run unit tests
	docker-compose run php bin/phpunit

behat: ## Run functional tests
	docker-compose run php vendor/bin/behat

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

info:
	@echo ""
	@echo "\033[92m[OK] Application running on http://$(HOST):8080\033[0m"
	@echo "\033[92m[OK] Minio running on http://$(HOST):9001\033[0m"
	@echo ""

##
##