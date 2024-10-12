<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TransferOrderException extends Exception
{
    // 可以自定義異常的屬性
    protected string $target;
    protected $message;
    protected mixed $statusCode;

    public function __construct($message = "transfer order failed", $statusCode = 400, $target = "")
    {
        $this->target = $target;
        $this->message = $message;
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode);
    }

    public function getTarget(): string
    {
        return $this->target;
    }
}
