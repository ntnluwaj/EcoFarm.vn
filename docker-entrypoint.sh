#!/bin/sh
# Force clean redeploy on Render

# Đảm bảo các thư mục đích tồn tại trong ổ đĩa mount
mkdir -p /var/www/html/storage/app/public/products
mkdir -p /var/www/html/storage/app/public/banners
mkdir -p /var/www/html/storage/app/public/agency_licenses
mkdir -p /var/www/html/storage/app/public/uploads
mkdir -p /var/www/html/storage/app/public/avatars
mkdir -p /var/www/html/storage/app/livewire-tmp
mkdir -p /var/www/html/storage/app/public/livewire-tmp
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/public/storage

# Khôi phục các tệp ảnh mẫu từ thư mục backup vào cả storage/app/public và public/storage
cp -R /var/www/html/storage_backup/* /var/www/html/storage/app/public/ 2>/dev/null || true
cp -R /var/www/html/storage_backup/* /var/www/html/public/storage/ 2>/dev/null || true

# Cấp quyền ghi tuyệt đối cho thư mục storage, public/storage và cache tại thời điểm chạy container
chmod -R 777 /var/www/html/storage /var/www/html/public/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/public/storage /var/www/html/bootstrap/cache || true

# 1. Tạo liên kết thư mục chứa ảnh
php artisan storage:link --force || true

# 1.5 Tự động loại bỏ background trắng của logo
php scratch/make_transparent.php || true

# 2. Xóa bộ nhớ cache cũ
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Tự động chạy di cư CSDL và nạp dữ liệu mẫu đồng bộ trước khi mở server
php artisan migrate --force || true
php artisan db:seed --force || true

# 4. Lưu cache cấu hình tối ưu
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Khởi động Apache Web Server ở tiền cảnh
exec apache2-foreground
