<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class BadRequestApiResponse extends ApiResponse
{
    public function __construct(mixed $errors)
    {
        parent::__construct(
            errors: $errors,
            httpStatusCode: Response::HTTP_BAD_REQUEST
        );
    }
}
