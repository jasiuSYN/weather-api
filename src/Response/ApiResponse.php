<?php

declare(strict_types=1);

namespace App\Response;

class ApiResponse
{
    public function __construct(private mixed $data, private mixed $errors, private int $httpStatusCode) {}

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