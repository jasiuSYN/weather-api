<?php

declare(strict_types=1);

namespace App\Message;

class SendNotificationDefinitionConfirmation
{
    public function __construct(private int $userId, private array $coordinates)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }
}