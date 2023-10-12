<?php

declare(strict_types=1);

namespace VolkLms\Poc\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010185512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create persons table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('persons');
        $table->addColumn('id', 'integer')
            ->setAutoincrement(true);
        $table
            ->addColumn('fullname', 'string');
        $table->setPrimaryKey(['id']);
    }

    public function postUp(Schema $schema): void
    {
        $persons = [
            ['fullname' => 'Milton Ruiz'],
            ['fullname' => 'Luana Salgado'],
            ['fullname' => 'Eric Maciel'],
            ['fullname' => 'Marília Medina'],
            ['fullname' => 'Cícero Nogueira'],
            ['fullname' => 'Diego Leal'],
            ['fullname' => 'Tereza Paschoal'],
            ['fullname' => 'Nina Moura'],
            ['fullname' => 'Iolanda Medeiros'],
            ['fullname' => 'Evandro Yoshimura'],
            ['fullname' => 'Alessandro Menezes'],
            ['fullname' => 'Lucas Jardim']
        ];

        foreach ($persons as $person) {
            $this->connection->insert('persons', $person);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('persons');
    }
}
