FROM jasiucode/dockerhub:php82-composer

COPY . /app
WORKDIR /app

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction