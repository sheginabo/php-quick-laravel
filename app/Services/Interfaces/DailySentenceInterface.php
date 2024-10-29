<?php

namespace App\Services\Interfaces;

interface DailySentenceInterface
{
    public function getSentence(): string | array;
}
