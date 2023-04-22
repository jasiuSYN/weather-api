<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SendNotificationDefinitionConfirmation;
use App\Repository\UserRepository;
use App\Response\ApiResponse;
use App\Response\BadRequestApiResponse;
use App\Response\SuccessApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddWeatherNotificationController extends AbstractController
{
    #[Route("/api/add-weather-notification", name: 'add-weather-notification', methods: 'POST')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        MessageBusInterface $messageBus
    ): ApiResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['coordinates'])) {
            return new BadRequestApiResponse(['error' => 'Email and coordinates are required.']);
        }

        $user = $userRepository->getByEmail($data['email']);

        $message = new SendNotificationDefinitionConfirmation(
            $user->getId(),
            $data['coordinates']
        );

        $messageBus->dispatch($message);

        return new SuccessApiResponse(['OK']);
    }
}
