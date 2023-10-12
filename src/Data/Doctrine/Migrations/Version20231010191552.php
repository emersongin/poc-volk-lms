<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010191552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create status table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('status');
        $table->addColumn('id', 'integer')
            ->setAutoincrement(true);
        $table->addColumn('description', 'string');
        $table->setPrimaryKey(['id']);
    }

    public function postUp(Schema $schema): void
    {
        $status = [
            ['description' => 'EM ANDAMENTO'],
            ['description' => 'PROCESSADO'],
            ['description' => 'CANCELADO'],
        ];

        foreach ($status as $state) {
            $this->connection->insert('status', $state);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('status');
    }
}
