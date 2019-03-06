.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help


##
##Community Event Manager "MEC"
##
##Setup
##-----
##
install:  .env run initialize book ## Install and start the project

book:
	#
	# Darkmira Community Event Manager
	#
	# Application: http://0.0.0.0:8080
	# Minio:       http://0.0.0.0:9001
	#

##
##Project
##-------
##

reset: kill install ## Stop and start a fresh install of the project

start: ## Start the project
	docker-compose up -d --remove-orphans --no-recreate

stop: ## Stop the project
	docker-compose down

clean: kill ## Stop the project and remove generated files
	rm -rf .env vendor node_modules

kill:
	docker-compose kill
	docker-compose down --volumes --remove-orphans

.PHONY: kill install reset start stop clean

all: run book

initialize: run bucket vendor
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



logs:
	docker-compose logs -ft

bash:
	docker-compose up -d php
	docker-compose exec php bash

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

vendor: composer.lock
	docker run -v $(shell pwd):/app -w /app composer:latest composer install

##
##Tests
##-----
##

coverage: vendor ## Run coverage unit tests
	docker-compose exec php bin/phpunit --coverage-html --coverage-text

test: tu tf ## Run unit and functional tests

tu: vendor ## Run unit tests
	docker-compose exec php bin/phpunit --exclude-group functional

tf: vendor ## Run functional tests
	docker-compose exec php vendor/bin/behat

.PHONY: tests tu tf

##
##Quality assurance
##-----------------
##

phpmd: vendor ## PHP Mess Detector (https://phpmd.org)
	docker-compose exec php vendor/bin/phpmd src text phpmd.xml


phpcpd: vendor ## PHP Copy/Paste Detector (https://github.com/sebastianbergmann/phpcpd)
	docker-compose exec php vendor/bin/phpcpd src

pdepend: vendor ## PHP_Depend (https://pdepend.org)
	docker-compose exec php vendor/bin/pdepend \
		--summary-xml=$(ARTEFACTS)/pdepend_summary.xml \
		--jdepend-chart=$(ARTEFACTS)/pdepend_jdepend.svg \
		--overview-pyramid=$(ARTEFACTS)/pdepend_pyramid.svg \
		src/

pretty: vendor ## PHP CS (https://github.com/squizlabs/PHP_CodeSniffer)
	docker-compose exec php vendor/bin/php-cs-fixer fix

.PHONY: pdepend phpmd pretty phpcpd

##
##