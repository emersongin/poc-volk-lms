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
            ['number' => '16.945.100/0001-20'],
            ['number' => '23.844.870/0001-42'],
            ['number' => '14.068.520/0001-40'],
            ['number' => '86.805.590/0001-45'],
            ['number' => '86.507.206/0001-28'],
            ['number' => '69.199.556/0001-55'],
            ['number' => '25.140.200/0001-70'],
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
