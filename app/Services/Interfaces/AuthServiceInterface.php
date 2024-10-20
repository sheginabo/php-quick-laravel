<?php

namespace App\Services\Interfaces;
interface AuthServiceInterface
{
    public function register(array $input): string;
    public function login(array $input): string;
}
