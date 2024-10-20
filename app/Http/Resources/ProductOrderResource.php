<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ProductOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof \Throwable) {
            return [
                'result' => 'failed',
                'message' => $this->resource->getMessage(),
            ];
        }

        if (isset($this->resource['error'])) {
            return [
                'result' => 'failed',
                'message' => $this->resource['error'],
            ];
        }


        if (is_object($this->resource)) {
            return [
                'order_number' => $this->order_number,
                'billing_email' => $this->billing_email,
            ];
        }

        return [
            'result' => 'success',
            'order' => [
                'order_number' => $this->order_number,
                'billing_email' => $this->billing_email,
            ],
        ];
    }

    /**
     * Customize the response for the resource.
     *
     * @param Request $request
     * @param \Illuminate\Http\JsonResponse $response
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setData($this->toArray($request));
    }
}
