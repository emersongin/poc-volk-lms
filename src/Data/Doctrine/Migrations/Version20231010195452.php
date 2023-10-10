<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010195452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create process queues table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('process_queues');
        $table->addColumn('process_id', 'integer', ['notnull' => true]);
        $table->addColumn('queue_id', 'integer', ['notnull' => true]);
        $table->addColumn('action_number', 'integer', ['notnull' => false]);
        $table->addForeignKeyConstraint('processes', ['process_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('process_queues');
    }
}
