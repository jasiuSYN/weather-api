<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\NotificationDefinition;
use App\Repository\NotificationDefinitionRepository;
use App\Response\ApiResponse;
use App\Response\NotFoundApiResponse;
use App\Response\SuccessApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificationDefinitionConfirmationController extends AbstractController
{
    /**
     * Perform a findOneBy() where the token property matches {token}.
     */
    #[Route("/api/confirm/{token}", name: 'token-confirmation', methods: 'GET')]
    public function __invoke(
        EntityManagerInterface $entityManager,
        NotificationDefinitionRepository $definitionRepository,
        string $token
    ): ApiResponse {

        $definitionFoundByToken = $definitionRepository->findOneByConfirmationToken($token);

        if (!$definitionFoundByToken) {
            return new NotFoundApiResponse([$token => 'Not found']);
        }

        $definitionFoundByToken->setIsConfirmed(true);
        $definitionRepository->save($definitionFoundByToken, true);

        return new SuccessApiResponse([$token => 'Confirmed']);
    }
}
