<?php

namespace src\Mood\Repository;

use src\DB\ConnectDB;

class MoodBaseRepository
{
    private $dbHandler;

    private $connectDb;

    public function __construct(ConnectDB $connectDB)
    {
        $this->connectDb = $connectDB;
        $this->dbHandler = $connectDB->getConnectDb();
    }

    public function findAll(): array
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `mood_base`');
        $query->execute();

        return $query->fetchAll();
    }

    public function findById(int $id): array
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `mood_base` WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();

        $result = $query->fetch();

        return $result;
    }
}
