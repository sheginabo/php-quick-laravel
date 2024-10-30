<?php

namespace App\Http\Resources\DailySentence;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailySentenceResource extends JsonResource
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

        return [
            'result' => 'success',
            'message' => $this->resource
        ];
    }

    /**
     * Customize the response for the resource.
     *
     * @param Request $request
     * @param JsonResponse $response
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setData($this->toArray($request));
    }
}
