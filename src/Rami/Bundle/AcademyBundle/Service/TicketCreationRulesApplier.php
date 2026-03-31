<?php

declare(strict_types=1);

namespace Rami\Bundle\AcademyBundle\Service;

use Rami\Bundle\AcademyBundle\Entity\Ticket;
use Rami\Bundle\AcademyBundle\Provider\TicketSystemConfigProvider;

class TicketCreationRulesApplier
{
    public function __construct(private readonly TicketSystemConfigProvider $configProvider)
    {
    }

    public function applyInitialValues(Ticket $ticket): void
    {
        $ticket->setPriority($this->configProvider->getDefaultPriority());
    }

    public function applyBusinessRules(Ticket $ticket): void
    {
        $defaultSlaHours = $this->configProvider->getDefaultSlaHours();
        $notificationsEnabled = $this->configProvider->areNotificationsEnabled();

        if ($defaultSlaHours <= 4 && Ticket::PRIORITY_LOW === $ticket->getPriority()) {
            $ticket->setPriority(Ticket::PRIORITY_MEDIUM);
        }

        if (!$notificationsEnabled && Ticket::PRIORITY_URGENT === $ticket->getPriority()) {
            $ticket->setPriority(Ticket::PRIORITY_HIGH);
        }
    }
}
