<?php

use src\DB\ConnectDB;
use src\User\Repository\UserRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/User/Repository/UserRepository.php");

$connectDB = new ConnectDB();

$existUser = false;

if (! empty($_POST)) {
    $data = [];
    extract($_POST);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $userRepository = new UserRepository($connectDB);

    if (! empty($username)) {
        $data[] = $username;
        try {
            $userRepository->HasUserByUsername($username);
            $existUser = true;
        } catch (Exception $e) {
            $existUser = false;
        }
    }

    if (! empty($password)) {
        $data[] = $password;
        if (! $existUser) {
            $userRepository->save($username, $password);
            header("location:login.php?success=true");
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8"/>
        <link type="text/css" rel="stylesheet" href="public/css/style.css">
        <title>Moodoo</title>
    </head>
    <body>
        <header class="register-title">Register</header>
        <div class="center">
            <form method="POST" action="index.php">
                <?php
                if (empty($data) && ! empty($_POST)) { ?>
                    <p>Remplissez les champs</p>
                <?php } ?>
                Username :
                <?php
                if ($existUser) { ?>
                    <p>This username is already used</p>
                <?php } ?>
                <br>
                <input class="champ" type="text" id="username" name="username">
                </br>
                <span class="margin-top">Password :</span>
                </br>
                <input class="champ" type="password" id="password" name="password">
                <br>
                <input class="submit" type="submit" value="REGISTER">
            </form>
            <a href="login.php">Si vous avez déjà un compte, cliquez-ici</a>
        </div>
    </body>
</html>
