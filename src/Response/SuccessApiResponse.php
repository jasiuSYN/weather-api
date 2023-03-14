<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class SuccessApiResponse extends ApiResponse
{
    public function __construct(mixed $data)
    {
        parent::__construct($data);
    }
}