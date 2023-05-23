<?php

declare(strict_types=1);

namespace App\Message;

class SendNotificationDefinitionConfirmation
{
    public function __construct(private int $definitionId)
    {
    }

    public function getDefinitionId(): int
    {
        return $this->definitionId;
    }
}