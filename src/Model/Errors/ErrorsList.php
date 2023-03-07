<?php

declare(strict_types=1);

namespace App\Model\Errors;

use Symfony\Component\HttpFoundation\Response;

class ErrorsList
{
    private array $errors = [];

    public function __construct(private int $httpStatusCode = Response::HTTP_BAD_REQUEST)
    {
    }

    /**
     * @return ErrorsList[]
     */
    public function addError(Error $error): array
    {
        $this->errors[] = $error;
        return $this->errors;
    }

    public function getErrorList(): array
    {
        return $this->errors;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function setHttpStatusCode(int $httpStatusCode): void
    {
        $this->httpStatusCode = $httpStatusCode;
    }
}