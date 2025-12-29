FROM php:8.4-cli

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y \
    libexif-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-install exif zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set entrypoint
ENTRYPOINT ["php", "photos-mover.php"]