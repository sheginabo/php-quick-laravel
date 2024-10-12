#!/bin/sh

echo "當前執行目錄: $(pwd)"
# 構建 Docker 映像
docker build -f ./Dockerfile.phpfpm.local -t phpfpm-local .
# 檢查 xdebug 是否安裝，若未安裝則安裝它
if ! php -m | grep -q 'xdebug'; then
  echo "xdebug 未安裝，正在安裝 xdebug"
  pecl install xdebug
  echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
  echo "xdebug.mode=coverage" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
  echo "xdebug.start_with_request=yes" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
  echo "xdebug 安裝完成"
else
  echo "xdebug 已安裝"
fi

# 檢查 .env 文件是否存在，若不存在則複製 .env.example 並生成應用密鑰
if [ ! -f ".env" ]; then
  echo ".env 文件不存在，複製 .env.example 並生成應用密鑰"
  cp .env.example .env
fi

# 檢查 vendor 資料夾是否存在，若不存在則執行 composer install
if [ ! -d "vendor" ]; then
  echo "Vendor 資料夾不存在，執行 composer install"
  composer install
fi

php artisan key:generate

# 檢查 DB 檔案
if [ ! -f ./database/database.sqlite ]; then
    touch ./database/database.sqlite
fi

# 執行數據庫遷移
php artisan migrate:fresh --seed

# 啟動 Docker Compose
docker-compose -p php-quick-laravel-local up -d

# Run tests with coverage
XDEBUG_MODE=coverage php artisan test --coverage
#XDEBUG_MODE=coverage php artisan test --coverage-html=coverage-report
