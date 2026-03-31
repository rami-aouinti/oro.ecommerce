<?php

namespace Rami\Bundle\AcademyBundle\Provider;

use Rami\Bundle\AcademyBundle\Entity\Ticket;
use Rami\Bundle\AcademyBundle\Extension\TicketApiResourceConfigProviderInterface;
use Rami\Bundle\AcademyBundle\Extension\TicketAsyncNotificationPublisherInterface;
use Rami\Bundle\AcademyBundle\Extension\TicketImportExportConfigProviderInterface;

class TicketExtensionPointRegistry
{
    /** @param iterable<TicketApiResourceConfigProviderInterface> $apiResourceConfigProviders */
    /** @param iterable<TicketImportExportConfigProviderInterface> $importExportConfigProviders */
    /** @param iterable<TicketAsyncNotificationPublisherInterface> $asyncNotificationPublishers */
    public function __construct(
        private readonly iterable $apiResourceConfigProviders,
        private readonly iterable $importExportConfigProviders,
        private readonly iterable $asyncNotificationPublishers
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getApiResourceConfigs(): array
    {
        $configs = [];

        foreach ($this->apiResourceConfigProviders as $provider) {
            $configs[] = $provider->getApiResourceConfig();
        }

        return $configs;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getImportExportConfigs(): array
    {
        $configs = [];

        foreach ($this->importExportConfigProviders as $provider) {
            $configs[] = $provider->getImportExportConfig();
        }

        return $configs;
    }

    public function publishAsyncNotifications(Ticket $ticket, bool $isCreation): void
    {
        foreach ($this->asyncNotificationPublishers as $publisher) {
            $publisher->publish($ticket, $isCreation);
        }
    }
}
