#!/usr/bin/env bash
# run things inside the php container
# run migrations
echo "Migrate tables and data"
vendor/bin/phinx migrate -e development
echo "Tables migrated"
