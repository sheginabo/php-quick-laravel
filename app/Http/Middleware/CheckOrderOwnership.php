<?php

namespace App\Http\Middleware;

use App\Models\ProductOrder;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CheckOrderOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();
        $orderId = $request->route('id');

        // 檢查該訂單是否屬於當前用戶
        $isOwnedByUser = ProductOrder::where('id', $orderId)->where('user_id', $userId)->exists();

        if (!$isOwnedByUser) {
            return response()->json(['error' => 'Unauthorized action.'], ResponseAlias::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
