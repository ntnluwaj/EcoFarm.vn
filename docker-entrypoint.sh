#!/bin/sh

# Cấp quyền ghi tuyệt đối cho thư mục storage và cache tại thời điểm chạy container
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# 1. Tạo liên kết thư mục chứa ảnh
php artisan storage:link --force || true

# 2. Xóa và tối ưu hóa bộ nhớ cache cấu hình
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Tự động chạy di cư CSDL và nạp dữ liệu mẫu vật tư
php artisan migrate --force
php artisan db:seed --force

# 4. Khởi động Apache Web Server ở tiền cảnh (chế độ tiêu chuẩn của Docker)
exec apache2-foreground
