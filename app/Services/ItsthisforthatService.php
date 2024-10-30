<?php

namespace App\Services;

use App\Services\Interfaces\DailySentenceInterface;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ItsthisforthatService extends ApiHandler implements DailySentenceInterface
{
    private const API_URL = 'http://itsthisforthat.com/api.php';

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function getSentence(): string
    {
        $response = $this->get(self::API_URL, [], ['text' => '']);
        return $this->handleResponse($response);
    }
}
