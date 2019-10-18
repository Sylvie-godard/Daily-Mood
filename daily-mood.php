<?php
use src\DB\ConnectDB;
use src\Mood\Repository\MoodRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/Mood/Repository/MoodRepository.php");

$connectDB = new ConnectDB();

$moodRepository = new MoodRepository($connectDB);
session_start();
$moods = $moodRepository->findByUserName($_SESSION['username']);

?>

<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8"/>
    <link type="text/css" rel="stylesheet" href="public/css/style.css">
    <title>Daily Mood</title>
</head>
<body>
<h1>DAILY MOOD</h1>
<?php
    foreach ($moods as $mood) {
        $description = $mood['description'];
        $label = $mood['mood_label'];
        $date = $mood['creation_date'];

        echo <<<EOT
        <div class='daily-mood'>
            <img src='public/img/$label' class='img-left'/>
            <img src='public/img/calendar-icon.png' class='calendar'/><p class='p-daily'>$date</p>
            <p class='p-daily-bold'>$description </p>
        </div>
EOT;
    }
?>

</body>
</html>

