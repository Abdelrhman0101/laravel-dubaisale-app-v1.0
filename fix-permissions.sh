#!/bin/bash
# Laravel Full Fix Permissions & Cache Script 🚀
# By دوام للتقنية

APP_DIR="/home/dubaisale/htdocs/dubaisale.app"
USER="www-data"
GROUP="www-data"

echo "🔧 Fixing ownership..."
chown -R $USER:$GROUP $APP_DIR

echo "🔧 Fixing file permissions..."
find $APP_DIR -type f -exec chmod 664 {} \;

echo "🔧 Fixing directory permissions..."
find $APP_DIR -type d -exec chmod 775 {} \;

echo "🔧 Ensuring storage & cache are writable..."
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

echo "🗑 Clearing Laravel caches..."
php $APP_DIR/artisan cache:clear
php $APP_DIR/artisan config:clear
php $APP_DIR/artisan route:clear
php $APP_DIR/artisan view:clear

echo "🔗 Regenerating storage symlink..."
rm -rf $APP_DIR/public/storage
php $APP_DIR/artisan storage:link

echo "✅ All permissions & caches fixed successfully!"
