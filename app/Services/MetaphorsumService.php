<?php

namespace App\Services;

use App\Services\Interfaces\DailySentenceInterface;
use Exception;
use Illuminate\Http\Client\ConnectionException;

class MetaphorsumService extends ApiHandler implements DailySentenceInterface
{
    private const BASE_URL = 'http://metaphorpsum.com';

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function getSentence(): string
    {
        $response = $this->get(self::BASE_URL . '/sentences/3');
        return $this->handleResponse($response);
    }
}
