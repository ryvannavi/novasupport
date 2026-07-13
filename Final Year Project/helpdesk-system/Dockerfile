FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl zip unzip git \
    libsqlite3-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_pgsql mbstring xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs
RUN npm install && npm run build
RUN cp .env.example .env
RUN php artisan key:generate --force
RUN php artisan config:clear

EXPOSE 8080
CMD ["sh", "-c", "printenv | grep -E '^(APP_|DB_|GROQ_|LOG_|SESSION_|CACHE_|QUEUE_|MAIL_)' > .env; (php artisan migrate --force &); php artisan serve --host=0.0.0.0 --port=8080"]