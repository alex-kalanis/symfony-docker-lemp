#!/usr/bin/env bash
# run things inside the container
# set rights for MariaDB
echo "Set user things"
mysql --user=root --password=951357456852 < /system_user.sql
echo "Things in db probably set"
# now we can migrate things
