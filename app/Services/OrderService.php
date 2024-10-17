<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    public function transferOrder(array $input): array
    {
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
}
