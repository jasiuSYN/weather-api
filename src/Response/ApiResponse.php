<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct(mixed $data, mixed $errors, int $httpStatusCode)
    {
        parent::__construct($this->format($data, $errors), $httpStatusCode);
    }
    private function format(mixed $data, mixed $errors): array
    {
        if ($data === null) {
            $data = new \ArrayObject();
        }

        $response = [
            'data' => $data,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return $response;
    }
}