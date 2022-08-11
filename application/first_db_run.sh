#!/usr/bin/env bash
# run things inside the container
# set rights for MariaDB
mysql --user=root --password=951357456852 < migrations/system_user.sql
# now we can migrate things
