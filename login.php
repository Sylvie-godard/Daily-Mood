<?php

use src\DB\ConnectDB;
use src\User\Repository\UserRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/User/Repository/UserRepository.php");

$connectDB = new ConnectDB();

$wrongDatas = false;

if (! empty($_POST)) {
    $userRepository = new UserRepository($connectDB);

    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $result = $userRepository->HasUserByUsername($username);
    } catch (Exception $e) {
        $wrongDatas = true;
    }

    if (! $wrongDatas) {
        if (\password_verify($password, $result['password']) && $username === $result['username']) {
            session_start();
            $_SESSION['username'] = $result['username'];
            header("location:pick-your-mood.php");
        } else {
            $wrongDatas = true;
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
<header class="register-title">LOGIN</header>
<div class="center">

    <form method="POST" action="login.php">
        <?php
        if ($wrongDatas) { ?>
            <p>Wrong username or password</p>
        <?php } ?>
        Username :
        <br>
        <input class="champ" type="text" id="username" name="username">
        </br>
        <span class="margin-top">Password :</span>
        </br>
        <input class="champ" type="password" id="password" name="password">
        <br>
        <input class="submit" type="submit" value="LOGIN">
    </form>
    <a href="index.php">Nouveau ici ? Veuillez-vous inscrire ici</a>
</div>
</body>
</html>
