<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010191145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create units table';
    }

    public function up(Schema $schema): void
    {
        $table  = $schema->createTable('units');
        $table->addColumn('id', 'integer')
            ->setAutoincrement(true);
        $table
            ->addColumn('number', 'string');
        $table->setPrimaryKey(['id']);
    }

    public function postUp(Schema $schema): void
    {
        $units = [
            ['number' => '11.111.111'],
            ['number' => '22.222.222'],
            ['number' => '33.333.333'],
        ];

        foreach ($units as $unit) {
            $this->connection->insert('units', $unit);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('units');
    }
}
