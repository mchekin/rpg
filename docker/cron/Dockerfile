FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Set working directory
WORKDIR /var/www

# Add crontab file in the cron directory
ADD ./docker/cron/scheduler /etc/cron.d/scheduler

# Apply the cron jobs
RUN crontab /etc/cron.d/scheduler

# run cron
CMD ["cron", "-f"]