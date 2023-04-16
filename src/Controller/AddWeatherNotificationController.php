<?php

declare(strict_types=1);

namespace App\Controller;

use App\Email\SendNotificationDefinitionConfirmation;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\UserRepository;
use App\Response\ApiResponse;
use App\Response\BadRequestApiResponse;
use App\Response\SuccessApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddWeatherNotificationController extends AbstractController
{
    #[Route("/api/add-weather-notification", name: 'add-weather-notification', methods: 'POST')]
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        SendNotificationDefinitionConfirmation $notificationDefinitionConfirmation,
        UserRepository $userRepository,
        NotificationDefinitionRepository $definitionRepository
    ): ApiResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['coordinates'])) {
            return new BadRequestApiResponse(['error' => 'Email and coordinates are required.']);
        }

        $user = $userRepository->getByEmail($data['email']);

        $notificationDefinition = $definitionRepository->getByUserAndCoordinates(
            $user,
            $data['coordinates']
        );

        $notificationDefinitionConfirmation->sendConfirmation($notificationDefinition);

        return new SuccessApiResponse(['OK']);
    }
}
