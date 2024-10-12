<?php

namespace App\Services;

use App\Exceptions\TransferOrderException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function transferOrder(array $input)
    {
        // TODO STEP 1: 進階驗證
        $this->validateOrderData($input);
        // TODO STEP 2: 資料處理
        $transferredData = $input;
        // 如果 currency 是 USD，將 price 轉換為 TWD 並覆寫 currency
        if ($transferredData['currency'] === 'USD') {
            $transferredData['price'] *= 31;
            $transferredData['currency'] = 'TWD';
            Log::debug('[OrderService_transferOrder] Transfer USD to TWD, orgData: ' . json_encode($input) . ', transferredData: ' . json_encode($transferredData));
        }

        return $transferredData;
    }

    /**
     * @throws TransferOrderException
     */
    private function validateOrderData(array &$input): void
    {
        // 驗證 name 是否包含非英文字母
        if (!ctype_alpha(preg_replace('/\s+/', '', $input['name']))) {
            throw new TransferOrderException('Name contains non-English characters', 400, 'name');
        }

        // 驗證 name 中每個單字字首是否大寫
        $words = preg_split('/\s+/', trim($input['name']));
        foreach ($words as $word) {
            if (ucfirst($word) !== $word) {
                throw new TransferOrderException('Name is not capitalized', 400, 'name');
            }
        }

        // 驗證 price 是否大於 2000
        if ($input['price'] > 2000) {
            throw new TransferOrderException('Price is over 2000', 400, 'price');
        }

        // 驗證 currency 是否為 TWD 或 USD
        if (!in_array($input['currency'], ['TWD', 'USD'])) {
            throw new TransferOrderException('Currency format is wrong', 400, 'currency');
        }
    }
}
