FROM jasiucode/php8.2:latest

COPY . /app
WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
