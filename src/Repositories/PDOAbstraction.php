<?php

namespace VolkLms\Poc\Repositories;

use PDO;

abstract class PDOAbstraction
{
    private PDO $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function beginTransaction(): PDOAbstraction
    {
        if ($this->connection->inTransaction()) return $this;
        $this->connection->beginTransaction();
        return $this;
    }

    public function commit(): PDOAbstraction
    {
        $this->connection->commit();
        return $this;
    }

    protected function lastInsertId(): int | string
    {
        return $this->connection->lastInsertId();
    }

    protected function runSQL($data): array | bool
    {
        $connect = $this->connection;
        $query = $connect->prepare($data['sql']);
        $query->execute($data['parameters']);
        if ($data['return']) {
            if ($data['multiple']) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return true;
    }
}
