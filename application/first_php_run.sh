#!/usr/bin/env bash
# run things inside the php container
# run migrations
vendor/bin/phinx migrate -e development
