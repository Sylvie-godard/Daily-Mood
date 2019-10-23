<?php

declare(strict_types=1);

namespace src\Mood\Repository;

use DateTime;
use src\DB\ConnectDB;

class MoodRepository
{
    private $dbHandler;

    private $connectDb;

    public function __construct(ConnectDB $connectDB)
    {
        $this->connectDb = $connectDB;
        $this->dbHandler = $connectDB->getConnectDb();
    }

    public function findAll()
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `mood`');
        $query->execute();

        return $query->fetchAll();
    }

    public function findByUserName(string $username)
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `mood` WHERE username = :username');
        $query->bindParam('username', $username);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param string $moodLabel
     * @param string $username
     * @param string $description
     *
     * @return bool
     * @throws \Exception
     */
    public function save(string $moodLabel, string $username, string $description): bool
    {
        $creationDate = new DateTime();

        $request = $this->dbHandler->prepare(
            'INSERT INTO `mood` (`mood_label`, `creation_date`, `description`, `username`) VALUES (:mood_label, :creation_date, :description, :username)'
        );

        $request->bindParam(':mood_label', $moodLabel);
        $request->bindParam(':creation_date', $creationDate);
        $request->bindParam(':description', $description);
        $request->bindParam(':username', $username);

        return $request->execute();
    }
}
