<?php

declare(strict_types=1);

namespace App\Model\Errors;

class Error
{
    private static array $errorCode = [
        'c1051bb4-d103-4f74-8988-acbcafc7fdc3' => 'WEATHER_REQUEST_PARAMETER_IS_EMPTY',
        '04b91c99-a946-4221-afc5-e65ebac401eb' => 'WEATHER_REQUEST_PARAMETER_IS_OUT_OF_RANGE',
        'ad9a9798-7a99-4df7-8ce9-46e416a1e60b' => 'WEATHER_REQUEST_PARAMETER_IS_NOT_VALID_NUMBER'
        ];
    private string $code;
    private string $message;

    public function __construct($code)
    {
        $this->code = $code;
        $this->message = self::$errorCode[$code];
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