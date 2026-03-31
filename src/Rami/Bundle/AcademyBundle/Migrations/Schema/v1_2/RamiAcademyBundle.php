<?php

namespace Rami\Bundle\AcademyBundle\Migrations\Schema\v1_2;

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

        if (!$table->hasColumn('contact_id')) {
            $table->addColumn('contact_id', Types::INTEGER, ['notnull' => false]);
            $table->addIndex(['contact_id'], 'idx_rami_ticket_contact');
        }

        if (!$table->hasColumn('account_id')) {
            $table->addColumn('account_id', Types::INTEGER, ['notnull' => false]);
            $table->addIndex(['account_id'], 'idx_rami_ticket_account');
        }

        if ($schema->hasTable('orocrm_contact') && !$table->hasForeignKey('FK_D7175E62E7A1254A')) {
            $table->addForeignKeyConstraint(
                $schema->getTable('orocrm_contact'),
                ['contact_id'],
                ['id'],
                ['onDelete' => 'SET NULL'],
                'FK_D7175E62E7A1254A'
            );
        }

        if ($schema->hasTable('orocrm_account') && !$table->hasForeignKey('FK_D7175E629B6B5FBA')) {
            $table->addForeignKeyConstraint(
                $schema->getTable('orocrm_account'),
                ['account_id'],
                ['id'],
                ['onDelete' => 'SET NULL'],
                'FK_D7175E629B6B5FBA'
            );
        }
    }
}
