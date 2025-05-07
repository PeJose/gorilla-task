FROM php:8.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist

ENTRYPOINT ["php", "bin/console"]
