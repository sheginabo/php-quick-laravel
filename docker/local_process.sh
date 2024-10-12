#!/bin/sh
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database
chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/database

# 提示開發者可以訪問 localhost:8080
echo "開發環境已啟動，您可以訪問 http://localhost:8080, http://localhost:8080/api/rawSQL, http://localhost:8080/api/phpinfo"
