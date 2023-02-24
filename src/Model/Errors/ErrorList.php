<?php

declare(strict_types=1);

namespace App\Model\Errors;

class ErrorList
{
    private array $errorList = [];

    /**
     * @return ErrorList[]
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
}