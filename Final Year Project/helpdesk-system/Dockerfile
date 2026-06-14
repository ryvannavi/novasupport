FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl zip unzip git \
    libsqlite3-dev \
    libonig-dev \
    libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build
RUN cp .env.example .env
RUN php artisan key:generate --force
RUN touch database/database.sqlite
RUN php artisan migrate --force
RUN php artisan config:clear

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
