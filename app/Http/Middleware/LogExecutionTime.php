<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogExecutionTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 記錄開始時間
        $start = microtime(true);

        // 執行請求並取得回應
        $response = $next($request);

        // 記錄結束時間並計算執行時間（毫秒）
        $executionTime = (microtime(true) - $start) * 1000;

        // 寫入日誌
        Log::debug('Request [' . $request->method() . '] ' . $request->fullUrl() . ' executed in ' . $executionTime . ' ms.');

        // 返回回應
        return $response;
    }
}
