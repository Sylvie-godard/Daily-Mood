<?php

use src\DB\ConnectDB;
use src\Mood\Repository\MoodBaseRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/Mood/Repository/MoodBaseRepository.php");
include_once("src/Mood/Repository/MoodRepository.php");

$connectDB = new ConnectDB();
$moodBaseRepository = new MoodBaseRepository($connectDB);
$moodsBase = $moodBaseRepository->findAll();
?>

<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8"/>
        <link type="text/css" rel="stylesheet" href="public/css/style.css">
        <title>How are you today</title>
    </head>
    <body>
        <h1>HOW ARE YOU TODAY ?</h1>
        <h2>PICK YOUR DAILY MOOD</h2>
        <div class="grid-container">
            <?php
            $linksList = [];
            foreach ($moodsBase as $moodBase) {
                $id = $moodBase['id'];
                $moodLabel = $moodBase['label'];
                $moodUrl = $moodBase['url'];
                $linksList[] =  <<<EOT
                <a href="mood.php?id=$id" class="$moodLabel" style="background-image:url('public/img/$moodUrl');" id="smile"></a>
EOT;
            }
            echo \implode($linksList);
            ?>
        </div>
    </body>
</html>
