# โหลด Base Image PHP 8.3
FROM php:8.3-fpm

# ติดตั้ง system packages ที่จำเป็น + CA certificates
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    ca-certificates \
 && update-ca-certificates \
 && rm -rf /var/lib/apt/lists/*

# ติดตั้ง PHP Extensions สำหรับ Laravel
RUN docker-php-ext-install bcmath pdo_mysql

# ติดตั้ง NodeJS เวอร์ชัน LTS ล่าสุด (v22 ตอนนี้)
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - \
 && apt-get update && apt-get install -y nodejs \
 && rm -rf /var/lib/apt/lists/*

# Copy file composer:latest ไว้ที่ /usr/bin/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# ถ้า build image พร้อมโค้ด (ถึงแม้ตอนรันจะถูก mount ทับด้วย volume ก็ตาม)
COPY . .

EXPOSE 9000
