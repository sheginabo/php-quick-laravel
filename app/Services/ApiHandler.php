<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiHandler
{
    /**
     * 發送 GET 請求
     *
     * @param string $url
     * @param array $headers
     * @param array $query
     * @return Response
     * @throws ConnectionException
     */
    protected function get(string $url, array $headers = [], array $query = []): Response
    {
        return Http::withHeaders($headers)->get($url, $query);
    }

    /**
     * 發送 POST 請求
     *
     * @param string $url
     * @param array $payload
     * @param array $headers
     * @return Response
     * @throws ConnectionException
     */
    protected function post(string $url, array $payload = [], array $headers = []): Response
    {
        return Http::withHeaders($headers)->post($url, $payload);
    }

    /**
     * handle API response
     *
     * @param Response $response
     * @return mixed
     * @throws \Exception
     */
    protected function handleResponse(Response $response): mixed
    {
        if ($response->successful()) {
            return $response->json() ?? $response->body();
        }

        throw new \Exception('API request failed: ' . $response->status());
    }
}
