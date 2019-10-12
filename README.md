# Community Event Manager

[![Build Status](https://travis-ci.org/DarkmiraTour/community-event-manager.svg?branch=develop)](https://travis-ci.org/DarkmiraTour/community-event-manager)

This is a web application with a collection of tools helping people organising community events such as multi-days
conference with reminders, CRM and such

## Pre-requirements

You will need Docker to build the application, find more information on [the docker installation documentation](https://docs.docker.com/install/)

## Installation

``` bash
# Clone the application
git clone https://github.com/DarkmiraTour/community-event-manager.git
cd community-event-manager/

# Build and initialize the project
make install
```

## Configuration

- Change environment variables in the `.env` file like you want

## Access

Once you are ready `make install` the project, and run it with:

``` bash
make
```

Then you should be able to access:

* Application : [http://127.0.0.1:8080](http://127.0.0.1:8080)
* Minio : [http://127.0.0.1:9001](http://127.0.0.1:9001)
* Mailhog : [http://127.0.0.1:8025](http://127.0.0.1:8025)

(NOTE: If you’re using Docker Toolbox, change 127.0.0.1 to the IP of your virtual machine, ie 192.168.99.100)

## Test

Run tests suite:

``` bash
make test
```
## Code Quality

Code style fixer:

``` bash
make cs
```
## License

This application is under [GPL-3.0 License](LICENSE).
