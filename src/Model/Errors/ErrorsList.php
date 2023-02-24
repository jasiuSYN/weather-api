<?php

declare(strict_types=1);

namespace App\Model\Errors;

use Symfony\Component\HttpFoundation\Response;

class ErrorsList
{
    private array $errorList = [];

    public function __construct(private int $httpStatusCode = Response::HTTP_BAD_REQUEST) {}

    /**
     * @return ErrorsList[]
     */
    public function addError(Error $error): array
    {
        $this->errorList[] = $error;
        return $this->errorList;
    }

    public function getErrorList(): array
    {
        return $this->errorList;
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