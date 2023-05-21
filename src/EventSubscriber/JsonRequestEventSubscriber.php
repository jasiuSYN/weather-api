<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Dawid Góra <dawid.gora@ultifide.com>
 */
class JsonRequestEventSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isJsonRequest($request)) {
            return;
        }

        $content = $request->getContent();

        if (empty($content)) {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            $response = new Response('Unable to parse request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($data === null) {
            return true;
        }

        $request->request->replace($data);

        return true;
    }
}
