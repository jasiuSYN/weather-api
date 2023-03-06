<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponseListener
{
    public function __construct(private SerializerInterface $serializer) {}

    public function onKernelView(ViewEvent $event)
    {
        $value = $event->getControllerResult();

        if ($value->getData())
        {
            $data = $this->serializer->serialize($value->getData(), 'json');
        }
        elseif ($value->getErrors())
        {
            $data = $this->serializer->serialize($value->getErrors(), 'json');
        }
        else
            $data = new \ArrayObject();

        $response = JsonResponse::fromJsonString($data, $value->getHttpStatusCode());

        $event->setResponse($response);

    }
}