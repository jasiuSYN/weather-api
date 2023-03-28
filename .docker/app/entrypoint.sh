#!/usr/bin/env bash

composer install

echo "$@"
docker-php-entrypoint "$@"
