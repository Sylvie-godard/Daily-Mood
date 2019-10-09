<?php

namespace src\DB;

use Exception;
use PDO;

class ConnectDB
{
    private $connectDB;

    public function __construct()
    {
        try {
            // Nouvel objet de base SQLite
            $this->connectDB = new PDO('sqlite:moodoo.db');
            // Quelques options
            $this->connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getConnectDb()
    {
        return $this->connectDB;
    }
}
