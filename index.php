<?php

use src\DB\ConnectDB;
use src\User\Repository\UserRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/User/Repository/UserRepository.php");

$connectDB = new ConnectDB();

$existUser = false;
$validData = null;
if (! empty($_POST)) {
    $data = [];


    $username = $_POST['username'];
    $password = $_POST['password'];

    if (! empty($username) && ! empty($password) && (\preg_match('#^[\p{L}\p{P}\p{N}]+$#', $password) === 0 || \preg_match('#^[\p{L}\p{P}\p{N}]+$#', $username) === 0)) {
        $validData = false;
    } else {
        $validData = true;
    }

    $userRepository = new UserRepository($connectDB);

    if (! empty($username)) {
        try {
            $userRepository->HasUserByUsername($username);
            $existUser = true;
        } catch (Exception $e) {
            $existUser = false;
        }
    }

    if (! empty($password)) {
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
                if ((empty($username) || empty($password)) && ! empty($_POST)) { ?>
                    <p>Remplissez tous les champs</p>
                <?php } ?>
                Username :
                <?php

                if ($existUser) {
                  echo <<<EOT
        <p>This username is already used</p>
EOT;
                }

                if($validData === false) {
                   echo <<<EOT
    <p>Specials characters are not allowed</p>
EOT;
                }
                ?>

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
