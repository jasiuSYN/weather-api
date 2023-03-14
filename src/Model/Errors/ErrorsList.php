<?php

declare(strict_types=1);

namespace App\Model\Errors;

use Symfony\Component\HttpFoundation\Response;

class ErrorsList
{
    private array $errors = [];

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
}