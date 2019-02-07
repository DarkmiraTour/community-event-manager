all: run book

travis: .env run initialize yarn

install: .env run initialize yarn book

initialize: run bucket
	docker-compose run composer install
	docker-compose exec php bash -c "php bin/console doctrine:migrations:migrate --no-interaction"
	docker-compose exec php bash -c "php bin/console doctrine:fixtures:load --no-interaction"

run: .env behat.yml
	docker-compose up -d

stop:
	docker-compose down

bucket:
	docker run --network container:`docker-compose ps -q storage` \
	           --entrypoint="" \
	           -v `pwd`:/app \
	           -w /app \
	           minio/mc \
	           /bin/sh -c "chmod +x ./docker/minio/create-bucket.sh && ./docker/minio/create-bucket.sh"

test:
	docker-compose run composer ./vendor/bin/simple-phpunit

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

book:

	 Darkmira Community Event Manager

	 Application: http://0.0.0.0:8080
	 Minio:       http://0.0.0.0:9001


yarn:  ## Run yarn process
yarn:  yarn-install yarn-upgrade yarn-dev

yarn-install: ## Run yarn install
	docker-compose exec node yarn install

yarn-upgrade: ## Run yarn upgrade
	docker-compose exec node yarn upgrade

yarn-dev: ## Run yarn run dev
	docker-compose exec node yarn run dev

yarn-prod: ## Run yarn run dev
	docker-compose exec node yarn run build