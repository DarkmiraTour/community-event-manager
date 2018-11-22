# Community Event Manager

This is a web application with a collection of tools helping people organising community events such as multi-days
conference with reminders, CRM and such

## Pre-requirements

You will need Docker to build the application, find more informations on [the docker installation documentation](https://docs.docker.com/install/)

## Installation

- Get the application with `git clone https://github.com/DarkmiraTour/community-event-manager.git`
- Build application : `docker-compose up -d`
- Copy env file : `cp .env.dist .env`
- Create database : `docker-compose exec php bin/console doctrine:migrations:migrate`
- To have install data : `docker-compose exec php bin/console doctrine:fixtures:load`

## Configuration

- Change environment variables in the `.env` file like you want

## Access

* Application : [http://127.0.0.1:8080](http://127.0.0.1:8080)
* Minio : [http://127.0.0.1:9001](http://127.0.0.1:9001)

(If you’re using docker toolbox, change the ip by the ip for your virtual machine, ie 192.168.99.100)
