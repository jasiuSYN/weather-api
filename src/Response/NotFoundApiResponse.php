<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class NotFoundApiResponse extends ApiResponse
{
    public function __construct(mixed $error)
    {
        parent::__construct(errors: $error, httpStatusCode: Response::HTTP_NOT_FOUND);
    }
}