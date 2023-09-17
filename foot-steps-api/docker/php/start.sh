#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}


if [ "$role" = "app" ]; then
    exec php-fpm

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
