<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ApiResponseListener
{
    public function onKernelView(ViewEvent $event): void
    {
        $value = $event->getControllerResult();

        if (!$value instanceof ApiResponse) {
            return;
        }

        $data = $value->getData();
        $errors = $value->getErrors();
        $statusCode = $value->getHttpStatusCode();

        $jsonResponse = new JsonResponse($this->format($data, $errors), $statusCode);

        $event->setResponse($jsonResponse);

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