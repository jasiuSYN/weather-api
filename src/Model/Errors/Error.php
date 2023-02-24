<?php

declare(strict_types=1);

namespace App\Model\Errors;

class Error
{
    private string $code;
    private string $message;

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}