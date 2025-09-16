FROM php:8.3-fpm

# Установим зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl \
    && docker-php-ext-enable pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установим Node.js (для фронта Laravel)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установим Composer глобально
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]
