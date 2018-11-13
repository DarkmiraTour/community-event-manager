#Community Event Manager

This is a web application with a collection of tools helping people organising community events such as multi-days
conference with reminders, CRM and such

## Pre-requirements

You need to have Docker to build the application, find more informations on [https://docs.docker.com/install/](https://docs.docker.com/install/)

##Installation

- Get the application with `git clone https://github.com/DarkmiraTour/community-event-manager.git`
- Build application : `docker-compose up -d`
- Create database : `docker-compose exec php bin/console doctrine:migrations:migrate`
- To have test datas : `docker-compose exec php bin/console doctrine:fixtures:load`

##Configuration

- Change environment variables in the `.env` file like you want

- Minio configuration
   * Get `S3_KEY` and `S3_SECRET` from the file `var/s3/.minio.sys/config/config.yml`
   * Go to [http://127.0.0.1:9001](http://127.0.0.1:9001) to access to Minio
   * Sign in with the `S3_KEY` in `Access Key` and the `S3_SECRET` in `Secret Key`
   * Click on `+` at the bottom of the screen, choose `Create bucket` and call him `events`
   * Place the cursor on the bucket in the list, click on the `more` button and choose `Edit policy`
   * Choose `Read and Write` and click on `Add`
   
##Access

* Application : [http://127.0.0.1:8080](http://127.0.0.1:8080)
* Minio : [http://127.0.0.1:9001](http://127.0.0.1:9001)
