<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public function __construct(
        private mixed $data = null,
        private mixed $errors = null,
        private int $httpStatusCode = Response::HTTP_OK
    ) {
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
