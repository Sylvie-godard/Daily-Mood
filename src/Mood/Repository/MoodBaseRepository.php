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


    public function findById(int $id)
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `mood_base` WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();

        $result = $query->fetch();

        return $result;
    }
}
