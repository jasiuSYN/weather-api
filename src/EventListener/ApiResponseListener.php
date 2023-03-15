<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponseListener
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $apiResponse = $event->getControllerResult();

        if (!$apiResponse instanceof ApiResponse) {
            return;
        }

        if ($apiResponse->getData()) {
            $body = $this->serializer->serialize($apiResponse->getData(), 'json');
        } elseif ($apiResponse->getErrors()) {
            $body = $this->serializer->serialize($apiResponse->getErrors(), 'json');
        } else {
            return;
        }

        $response = JsonResponse::fromJsonString($body, $apiResponse->getHttpStatusCode());

        $event->setResponse($response);
    }
}
