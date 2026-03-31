<?php

namespace Rami\Bundle\AcademyBundle\Extension;

interface TicketApiResourceConfigProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getApiResourceConfig(): array;
}
