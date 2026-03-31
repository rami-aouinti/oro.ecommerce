<?php

namespace Rami\Bundle\AcademyBundle\Extension;

use Rami\Bundle\AcademyBundle\Entity\Ticket;

interface TicketAsyncNotificationPublisherInterface
{
    public function publish(Ticket $ticket, bool $isCreation): void;
}
