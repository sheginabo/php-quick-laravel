# php-quick-laravel

想要快速利用 Laravel POC 一些概念，這個專案提供了一個簡單的 Laravel 應用程式。
1. phpInfo 檢查
   - GET /api/phpinfo

## Getting Started
### Prerequisites

- PHP (Version 8.3 or later)
- Docker
- K6 (Optional for Load Testing)

### Running Locally

To run the project locally for debugging purposes, follow these steps:
1. **Clone project 並且移動至根目錄**
    ```bash
    git clone https://github.com/sheginabo/php-quick-laravel.git && cd php-quick-laravel
    ```
2. **給予懶人腳本權限**
    ```bash
    chmod +x ./docker/build_local.sh
    chmod +x ./docker/build_deploy.sh
    ```
3. **懶人腳本解說**
    ```
    build_local.sh
    ```
   - 建立一組 Container 將project 掛進去執行環境方便改 Code (極致低配 Laradock)
    ```
    build_deploy.sh
    ```
   - 建立一組 Container 將開發完成的專案放進 image (丟 ECR 或是 DockerHub 之前本地檢查品質)
4. **位於專案根目錄執行 build_deploy.sh 驗證包成 image**
    ```bash
    ./docker/build_deploy.sh
    ```
5. **完成會提示可以透過 http://localhost:8080, http://localhost:8080/api/orders 驗證**

6. **壓力測試(need k6 first)**
    ```bash
    k6 run ./k6/test.js
    ```
