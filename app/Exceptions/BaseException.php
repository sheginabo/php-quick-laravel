<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BaseException extends Exception
{
    protected string $target;

    public function __construct($message = "", $statusCode = 400, $target = "")
    {
        $this->target = $target;
        parent::__construct($message, $statusCode);
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'target' => $this->getTarget(),
        ], $this->getCode());
    }
}
