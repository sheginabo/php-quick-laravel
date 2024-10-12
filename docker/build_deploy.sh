#!/bin/sh

echo "當前執行目錄: $(pwd)"
# 構建 Docker 映像
docker build -f ./Dockerfile.phpfpm.deploy -t phpfpm-deploy .
# 啟動 Docker Compose
#docker-compose -p php-quick-laravel-deploy up -d
docker compose -p php-quick-laravel-deploy up --build --force-recreate -d
# 提示開發者可以訪問 localhost:8080
echo "部署環境已啟動，您可以訪問 http://localhost:8080, http://localhost:8080/api/rawSQL, http://localhost:8080/api/phpinfo"

