<?php

namespace App\Http\Controllers;

use App\Factories\DailySentenceFactory;
use App\Http\Resources\DailySentenceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class DailySentenceController extends Controller
{
    private $factory;

    public function __construct(DailySentenceFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getSentence(string $type = 'metaphorsum'): JsonResponse
    {
        try {
            $service = $this->factory->make($type);
            $result = $service->getSentence();

            $httpStatusCode = ResponseAlias::HTTP_OK;
            if (isset($result['error'])) {
                $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            }

            return (new DailySentenceResource($result))->response()->setStatusCode($httpStatusCode);
        } catch (Throwable $e) {
            return (new DailySentenceResource($e))->response()->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
