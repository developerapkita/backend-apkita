# Gunakan image dasar PHP dengan FPM
FROM php:8.2-fpm
# Perbarui daftar paket dan instal ekstensi yang diperlukan
RUN apt-get update \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpq-dev \
        libxml2-dev \
        libonig-dev \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instal Composer secara eksplisit
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www/html

# Salin file aplikasi ke kontainer
COPY . .

# Instal dependensi aplikasi
RUN composer self-update --1

# Ekspose port 9000
EXPOSE 8004

# Jalankan PHP-FPM
CMD ["php-fpm"]