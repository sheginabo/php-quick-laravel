import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
    stages: [
        { duration: '2m', target: 50 },    // 2分鐘內漸增至50用戶
        { duration: '3m', target: 200 },  // 10分鐘內增加到200用戶
        { duration: '1m', target: 200 },  // 保持200用戶2分鐘
        { duration: '3m', target: 0 },     // 5分鐘內減少到0用戶
    ],
};

// 使用者需要在這裡設定自己的 Sanctum Token
const token = '1|E6YZIRYHacJfwACGUVB1jRYsdW4GqSEs6VZVTetud86fdfd5';

export default function () {
    const headers = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',  // Ensure Content-Type is set to application/json
    };

    const orderData = JSON.stringify({
        "currency": "TW",
        "type": "A",
        "tax_amount": 100,
        "total_amount": 1000,
        "billing_email": "custom123@yopmail.com",
        "payment_method": "Free Shipping",
        "payment_method_title": "Free Shipping",
        "items": [
            {
                "product_id": 1,
                "order_item_quantity": 1,
                "order_item_name": "Product 1",
                "order_item_type": "physical"
            }
        ]
    });

    // 測試 POST http://localhost:8080/api/product/order
    let postResponse = http.post('http://localhost:8080/api/product/order', orderData, { headers });
    //console.log(JSON.stringify(postResponse.body, null, 2));
    check(postResponse, {
        'POST /api/product/order status is 200': (r) => r.status === 200,
    });

    sleep(10);

    // 測試 GET http://localhost:8080/api/product/order/all
    // let getResponse = http.get('http://localhost:8080/api/product/order/all', { headers });
    // check(getResponse, {
    //     'GET /api/product/order/all status is 200': (r) => r.status === 200,
    // });
    //
    // sleep(1);
}
