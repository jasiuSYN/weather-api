<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\NotificationDefinition;
use App\Entity\User;
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
    public function __invoke(Request $request, EntityManagerInterface $entityManager): ApiResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['coordinates'])) {
            return new BadRequestApiResponse(['error' => 'Email and coordinates are required.']);
        }


        $user = $entityManager->getRepository(User::class)->getByEmail($data['email']);

        $notificationDefinition = $entityManager->getRepository(NotificationDefinition::class)->create($user);

        dd($notificationDefinition);

        if ($user) {
            return new SuccessApiResponse(['OK']);
        } else {
            return new BadRequestApiResponse(['error']);
        }
    }
}
