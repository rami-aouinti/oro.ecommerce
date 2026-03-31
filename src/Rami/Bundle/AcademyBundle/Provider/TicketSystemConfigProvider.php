<?php

declare(strict_types=1);

namespace Rami\Bundle\AcademyBundle\Provider;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Rami\Bundle\AcademyBundle\Entity\Ticket;

class TicketSystemConfigProvider
{
    private const CONFIG_DEFAULT_SLA_HOURS = 'rami_academy.default_sla_hours';
    private const CONFIG_DEFAULT_PRIORITY = 'rami_academy.default_priority';
    private const CONFIG_NOTIFICATIONS_ENABLED = 'rami_academy.notifications_enabled';

    public function __construct(private readonly ConfigManager $configManager)
    {
    }

    public function getDefaultSlaHours(): int
    {
        $value = $this->configManager->get(self::CONFIG_DEFAULT_SLA_HOURS);

        if (null === $value || '' === $value) {
            return 24;
        }

        return max(1, (int) $value);
    }

    public function getDefaultPriority(): string
    {
        $priority = (string) $this->configManager->get(self::CONFIG_DEFAULT_PRIORITY);

        if (!in_array($priority, $this->getSupportedPriorities(), true)) {
            return Ticket::PRIORITY_MEDIUM;
        }

        return $priority;
    }

    public function areNotificationsEnabled(): bool
    {
        $value = $this->configManager->get(self::CONFIG_NOTIFICATIONS_ENABLED);

        if (null === $value || '' === $value) {
            return true;
        }

        return (bool) $value;
    }

    /**
     * @return string[]
     */
    private function getSupportedPriorities(): array
    {
        return [
            Ticket::PRIORITY_LOW,
            Ticket::PRIORITY_MEDIUM,
            Ticket::PRIORITY_HIGH,
            Ticket::PRIORITY_URGENT,
        ];
    }
}
