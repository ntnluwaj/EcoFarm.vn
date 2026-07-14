FROM php:8.2-apache

# Thiết lập log channel mặc định ghi ra stderr (stdout của container) để tránh lỗi quyền ghi tệp tin logs trên cloud
ENV LOG_CHANNEL=stderr

# 1. Cài đặt các công cụ hệ thống và thư viện cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Cài đặt các PHP extension bắt buộc cho Laravel (MySQL và PostgreSQL)
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# 3. Kích hoạt module rewrite của Apache (để chạy đường dẫn thân thiện của Laravel)
RUN a2enmod rewrite

# 4. Thay đổi Document Root của Apache hướng vào thư mục /public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Cài đặt Composer (Trình quản lý thư viện PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Cài đặt Node.js và NPM để biên dịch asset (Vite)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 7. Thiết lập thư mục làm việc và copy toàn bộ mã nguồn vào container
WORKDIR /var/www/html
COPY . .

# 8. Cài đặt các gói PHP (Composer) và JS (NPM)
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs
RUN php artisan filament:assets
RUN npm install && npm run build

# 9. Cấp quyền ghi cho các thư mục cache và storage của Laravel
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Copy tập lệnh khởi chạy vào bin hệ thống
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Thiết lập cổng mạng mặc định cho container
EXPOSE 80

# Chạy tập lệnh entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]
