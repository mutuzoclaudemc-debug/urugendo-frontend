FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs && apt-get clean

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install Node dependencies and build assets
COPY package.json package-lock.json vite.config.js ./
COPY resources/css resources/css
COPY resources/js resources/js
RUN npm ci && npm run build

# Copy the rest of the app
COPY . .

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Point Apache at Laravel's public/ folder
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/conf-available/docker-php.conf

# Render injects $PORT — Apache must listen on it
COPY docker/apache-start.sh /usr/local/bin/apache-start.sh
RUN chmod +x /usr/local/bin/apache-start.sh

CMD ["/usr/local/bin/apache-start.sh"]
