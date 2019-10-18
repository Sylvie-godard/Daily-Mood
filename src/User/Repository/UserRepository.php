<?php

namespace src\User\Repository;

use src\DB\ConnectDB;

class UserRepository
{
    private $dbHandler;

    private $connectDb;

    public function __construct(ConnectDB $connectDB)
    {
        $this->connectDb = $connectDB;
        $this->dbHandler = $connectDB->getConnectDb();
    }

    /**
     * @param string $username
     *
     * @return bool
     * @throws \Exception
     */
    public function HasUserByUsername(string $username)
    {
        $query = $this->dbHandler->prepare('SELECT * FROM `user` WHERE username = :username');
        $query->bindParam(':username', $username);
        $query->execute();

        $result = $query->fetch();

        if (! $result) {
            throw new \Exception('User with username '.$username.' does\'nt exist');
        }

        return $result;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function save(string $username, string $password): bool
    {
        $password = \password_hash($password, PASSWORD_DEFAULT);
        $request = $this->dbHandler->prepare('INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)');
        $request->bindParam('username', $username);
        $request->bindParam('password', $password);

        return $request->execute();
    }
}
