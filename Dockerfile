FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views

RUN touch database/database.sqlite

RUN php artisan config:clear

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000