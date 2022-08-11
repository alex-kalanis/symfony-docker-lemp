#!/usr/bin/env bash

# install this application, so it's simple to run it
# at first run docker
docker-compose up -d
# then run things inside mariadb - rights
docker exec -it k-symfony-mariadb /bin/bash first_db_run.sh
# then run things inside php - migrations
docker exec -it k-symfony-php7 /bin/bash first_php_run.sh
# now you're good
