<?php
use src\DB\ConnectDB;
use src\Mood\Repository\MoodBaseRepository;
use src\Mood\Repository\MoodRepository;

include_once("src/DB/ConnectDB.php");
include_once("src/Mood/Repository/MoodBaseRepository.php");
include_once("src/Mood/Repository/MoodRepository.php");

$connectDB = new ConnectDB();

$moodBaseRepository = new MoodBaseRepository($connectDB);
$moodBase = $moodBaseRepository->findById($_GET['id']);


session_start();

if (empty($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

if (! empty($_POST)) {
    $story = $_POST['story'];

    if (isset($_POST['skip'])) {
        header("location:pick-your-mood.php");
    }

    if (! empty($story) && isset($_POST['okay'])) {
        $moodRepository = new MoodRepository($connectDB);
        $mood = $moodRepository->save($moodBase['url'], $_SESSION['username'], $story);
        header("location:daily-mood.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8"/>
        <link type="text/css" rel="stylesheet" href="public/css/style.css">
        <title>How was you day</title>
    </head>
    <body>
        <h1>HOW AS YOUR DAY ?</h1>
        <div class="carre">
            <form method="POST" action="#" class="zone">
                <img src="public\img\<?php echo $moodBase['url'] ?>" alt="" class="img-center">
                <textarea id="story" name="story" rows="15" cols="45" class="text-area" placeholder="Write here about your day"></textarea>
                <input class="skip-okay" type="submit" name="skip" value="SKIP">
                <input class="skip-okay" type="submit" name="okay" value="OKAY">
            </form>
        </div>
    </body>
</html>
