<?php

namespace Rami\Bundle\AcademyBundle\Extension;

interface TicketImportExportConfigProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getImportExportConfig(): array;
}
