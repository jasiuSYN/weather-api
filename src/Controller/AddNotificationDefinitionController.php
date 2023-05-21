<?php

declare(strict_types=1);

namespace App\Controller;

use App\Client\Weather\OpenWeatherMap\Client;
use App\Entity\NotificationDefinition;
use App\Entity\User;
use App\Message\SendNotificationDefinitionConfirmation;
use App\Model\NotificationDefinition\AddNotificationDefinitionInput;
use App\Repository\NotificationDefinitionRepository;
use App\Repository\UserRepository;
use App\Response\ApiResponse;
use App\Response\BadRequestApiResponse;
use App\Response\SuccessApiResponse;
use App\Utility\Errors\ValidationErrorsToErrorListTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddNotificationDefinitionController extends AbstractController
{
    public function __construct(
        private ValidatorInterface $validator,
        private ValidationErrorsToErrorListTransformer $errorListTransformer
    ) {
    }

    #[Route("/api/add-weather-notification", name: 'add-weather-notification', methods: 'POST')]
    public function __invoke(
        Request $request,
        Client $client,
        UserRepository $userRepository,
        NotificationDefinitionRepository $definitionRepository,
        MessageBusInterface $messageBus,
    ): ApiResponse {
        $requestData = $request->request->all();

        $addNotificationDefinitionInput = AddNotificationDefinitionInput::fromArray($requestData);

        $errors = $this->validator->validate($addNotificationDefinitionInput);

        if (count($errors) > 0) {
            $errorList = $this->errorListTransformer->transformToErrorList($errors);

            return new BadRequestApiResponse($errorList);
        }

        $user = $userRepository->findByEmail($addNotificationDefinitionInput->getEmail());

        if (empty($user)) {
            $user = User::create($addNotificationDefinitionInput->getEmail());
            $userRepository->save($user, true);
        }

        $localizationName = $client->fetchLocalizationName(
            $addNotificationDefinitionInput->getLatitude(),
            $addNotificationDefinitionInput->getLongitude()
        );

        $notificationDefinition = $definitionRepository->findByUserCoordinatesLocalizationName(
            $user,
            $addNotificationDefinitionInput->getLatitude(),
            $addNotificationDefinitionInput->getLongitude(),
            $localizationName
        );

        if (empty($notificationDefinition)) {
            $notificationDefinition = NotificationDefinition::create(
                $user,
                $addNotificationDefinitionInput->getLatitude(),
                $addNotificationDefinitionInput->getLongitude(),
                $localizationName
            );
            $definitionRepository->save($notificationDefinition, true);
        } else {
            throw new \Exception('Notification definition already exists');
        }

        $message = new SendNotificationDefinitionConfirmation($notificationDefinition->getId());

        $messageBus->dispatch($message);

        return new SuccessApiResponse(['OK']);
    }
}
