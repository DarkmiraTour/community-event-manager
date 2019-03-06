# Community Event Manager

This is a web application with a collection of tools helping people organising community events such as multi-days
conference with reminders, CRM and such

## Pre-requirements

You will need Docker to build the application, find more informations on [the docker installation documentation](https://docs.docker.com/install/)

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

Once you already `make install` the project, run it with:

``` bash
make
```

Then you should access to:

* Application : [http://127.0.0.1:8080](http://127.0.0.1:8080)
* Minio : [http://127.0.0.1:9001](http://127.0.0.1:9001)

(NOTE: If you’re using Docker Toolbox, change 127.0.0.1 by the ip of your virtual machine, ie 192.168.99.100)

## Test

Run tests suite:

``` bash
make test
```

## Code Quality

Rules:

 ######need to be define 

Run quality cleanner:

``` bash
make pretty
```

## License

This application is under [GPL-3.0 License](LICENSE).
