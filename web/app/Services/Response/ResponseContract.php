<?php

namespace App\Services\Response;

interface ResponseContract
{
    public function changeStatus(): self;

    public function add(string $key, $data): self;

    public function response(string $errorCode = ''): array;


}