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

    public function postUp(Schema $schema): void
    {
        $processes = [
            [
                'name'      => 'Importação de unidades 1',
                'person_id' => 1,
                'unit_id'   => 2,
                'status_id' => 1,
                'queue_action_id' => 1,
            ],
            [
                'name'      => 'Importação de unidades 2',
                'person_id' => 2,
                'unit_id'   => 2,
                'status_id' => 1,
                'queue_action_id' => 1,
            ],
            [
                'name'      => 'Importação de unidades 3',
                'person_id' => 3,
                'unit_id'   => 2,
                'status_id' => 1,
                'queue_action_id' => 1,
            ],
            [
                'name'      => 'Importação de cargos 1',
                'person_id' => 3,
                'unit_id'   => 1,
                'status_id' => 2,
                'queue_action_id' => 2,
            ],
            [
                'name'      => 'Importação de cargos 2',
                'person_id' => 4,
                'unit_id'   => 1,
                'status_id' => 1,
                'queue_action_id' => 2,
            ],
            [
                'name'      => 'Importação de cargos 3',
                'person_id' => 5,
                'unit_id'   => 1,
                'status_id' => 1,
                'queue_action_id' => 2,
            ],
            [
                'name'      => 'Importação de cargos 4',
                'person_id' => 6,
                'unit_id'   => 3,
                'status_id' => 3,
                'queue_action_id' => 2,
            ],
            [
                'name'      => 'Importação de pessoas 1',
                'person_id' => 7,
                'unit_id'   => 5,
                'status_id' => 1,
                'queue_action_id' => 4,
            ],
            [
                'name'      => 'Importação de pessoas 2',
                'person_id' => 8,
                'unit_id'   => 5,
                'status_id' => 1,
                'queue_action_id' => 4,
            ],
            [
                'name'      => 'Importação de pessoas 3',
                'person_id' => 9,
                'unit_id'   => 6,
                'status_id' => 2,
                'queue_action_id' => 4,
            ],
            [
                'name'      => 'Certificados em lote 1',
                'person_id' => 12,
                'unit_id'   => 2,
                'status_id' => 2,
                'queue_action_id' => 7,
            ],
            [
                'name'      => 'Certificados em lote 2',
                'person_id' => 12,
                'unit_id'   => 3,
                'status_id' => 2,
                'queue_action_id' => 7,
            ],
            [
                'name'      => 'Certificados em lote 3',
                'person_id' => 12,
                'unit_id'   => 4,
                'status_id' => 2,
                'queue_action_id' => 7,
            ],
            [
                'name'      => 'Certificados em lote 4',
                'person_id' => 12,
                'unit_id'   => 5,
                'status_id' => 2,
                'queue_action_id' => 7,
            ],
        ];

        foreach ($processes as $process) {
            $this->connection->insert('processes', $process);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('processes');
    }
}
