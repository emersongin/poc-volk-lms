<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010191848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create queue actions table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('queue_actions');
        $table->addColumn('id', 'integer')
            ->setAutoincrement(true);
        $table->addColumn('description', 'string');
        $table->setPrimaryKey(['id']);
    }

    public function postUp(Schema $schema): void
    {
        $actions = [
            ['description' => 'Importação de unidades', 'id' => 1],
            ['description' => 'Importação de cargos', 'id' => 2],
            ['description' => 'Importação de setores', 'id' => 3],
            ['description' => 'Importação de pessoas', 'id' => 4],
            ['description' => 'Importação de cursos', 'id' => 5],
            ['description' => 'Importação de matriculas', 'id' => 6],
            ['description' => 'Certificados em lote', 'id' => 7],
        ];

        foreach ($actions as $action) {
            $this->connection->insert('queue_actions', $action);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('queue_actions');
    }
}
