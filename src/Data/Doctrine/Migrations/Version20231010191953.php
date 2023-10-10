<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010191953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create processes table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('processes');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('name', 'string');
        $table->addColumn('person_id', 'integer', ['notnull' => true]);
        $table->addColumn('unit_id', 'integer', ['notnull' => true]);
        $table->addColumn('status_id', 'integer', ['notnull' => true]);
        $table->addColumn('queue_action_id', 'integer', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('persons', ['person_id'], ['id']);
        $table->addForeignKeyConstraint('units', ['unit_id'], ['id']);
        $table->addForeignKeyConstraint('status', ['status_id'], ['id']);
        $table->addForeignKeyConstraint('queue_actions', ['queue_action_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('processes');
    }
}
