<?php

declare(strict_types=1);

namespace App\Model\Errors;

class Error
{
    private string $code;
    private ?string $message;
    private ?string $context;

    public function __construct($code, $message, $context=null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->context = $context;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }
}