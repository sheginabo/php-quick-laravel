<?php

namespace App\Factories;

use App\Services\Interfaces\DailySentenceInterface;
use App\Services\MetaphorsumService;
use App\Services\ItsthisforthatService;

class DailySentenceFactory
{
    public function make(string $type): DailySentenceInterface
    {
        return match ($type) {
            'metaphorsum' => app(MetaphorsumService::class),
            'itsthisforthat' => app(ItsthisforthatService::class),
            default => throw new \InvalidArgumentException("Invalid daily sentence type: {$type}"),
        };
    }
}
