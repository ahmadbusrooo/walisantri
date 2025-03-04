FROM php:5.6-apache

# Atur user dan group untuk www-data
RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

# Aktifkan mod_rewrite dan instal ekstensi PHP dasar
RUN a2enmod rewrite && \
    docker-php-ext-install mysqli pdo pdo_mysql mbstring

# Perbaiki repository sources untuk Debian Stretch
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's|security.debian.org|archive.debian.org/|g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

# Install dependensi tambahan untuk git, libzip dan ekstensi zip
RUN apt-get update -o Acquire::Check-Valid-Until=false && \
    apt-get install -y --allow-unauthenticated \
        git \
        libzip-dev && \
    docker-php-ext-install zip && \
    rm -rf /var/lib/apt/lists/*

# --- Bagian baru: Install dependensi dan ekstensi GD ---
RUN apt-get update -o Acquire::Check-Valid-Until=false && \
    apt-get install -y --allow-unauthenticated \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd && \
    rm -rf /var/lib/apt/lists/*

# Setel document root di Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Buat direktori tambahan untuk sesi dan log aplikasi
RUN mkdir -p /var/www/ci_sessions && \
    mkdir -p /var/www/html/application/cache && \
    mkdir -p /var/www/html/application/logs

# Atur permission pada direktori penting
RUN chown -R www-data:www-data /var/www/ci_sessions /var/www/html/application && \
    chmod -R 775 /var/www/ci_sessions /var/www/html/application

# Salin kode aplikasi ke dalam container
COPY --chown=www-data:www-data ./app /var/www/html

# Salin konfigurasi Apache khusus
COPY docker/apache/apache-config.conf /etc/apache2/sites-available/000-default.conf
