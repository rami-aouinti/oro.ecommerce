<?php

namespace Rami\Bundle\AcademyBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class RamiAcademyBundle implements Migration
{
    public function up(Schema $schema, QueryBag $queries): void
    {
        if (!$schema->hasTable('rami_academy_ticket')) {
            return;
        }

        $table = $schema->getTable('rami_academy_ticket');

        if (!$table->hasColumn('organization_id')) {
            $table->addColumn('organization_id', Types::INTEGER, ['notnull' => false]);
            $table->addIndex(['organization_id'], 'idx_rami_ticket_organization');
        }

        if (!$table->hasForeignKey('FK_D7175E6232C8A3DE')) {
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_organization'),
                ['organization_id'],
                ['id'],
                ['onDelete' => 'SET NULL'],
                'FK_D7175E6232C8A3DE'
            );
        }
    }
}
