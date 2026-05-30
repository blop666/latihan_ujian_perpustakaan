FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libzip-dev zip unzip git mariadb-client
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN cp .env.example .env && php artisan key:generate
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
