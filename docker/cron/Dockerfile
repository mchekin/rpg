FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Create the log file
RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log

# Add crontab file in the cron directory
ADD ./docker/cron/scheduler /etc/cron.d/scheduler

# Apply the cron jobs
RUN crontab /etc/cron.d/scheduler

# run cron
CMD ["cron", "-f"]