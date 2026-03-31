<?php

namespace Rami\Bundle\AcademyBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class RamiAcademyBundle implements Migration
{
    public function up(Schema $schema, QueryBag $queries): void
    {
        $this->createTicketTable($schema);
        $this->addTicketForeignKeys($schema);
    }

    private function createTicketTable(Schema $schema): void
    {
        $table = $schema->createTable('rami_academy_ticket');
        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $table->addColumn('subject', Types::STRING, ['length' => 255]);
        $table->addColumn('description', Types::TEXT, ['notnull' => false]);
        $table->addColumn('status', Types::STRING, ['length' => 32]);
        $table->addColumn('priority', Types::STRING, ['length' => 32]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, []);
        $table->addColumn('owner_id', Types::INTEGER, ['notnull' => false]);
        $table->addColumn('assigned_to_id', Types::INTEGER, ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['status'], 'idx_rami_ticket_status');
        $table->addIndex(['priority'], 'idx_rami_ticket_priority');
        $table->addIndex(['created_at'], 'idx_rami_ticket_created_at');
        $table->addIndex(['owner_id'], 'idx_rami_ticket_owner');
        $table->addIndex(['assigned_to_id'], 'idx_rami_ticket_assigned_to');
    }

    private function addTicketForeignKeys(Schema $schema): void
    {
        $table = $schema->getTable('rami_academy_ticket');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_business_unit'),
            ['owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL']
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assigned_to_id'],
            ['id'],
            ['onDelete' => 'SET NULL']
        );
    }
}
