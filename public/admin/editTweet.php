<?php

include_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['tweetId'])) {
    $tweetId = $_GET['tweetId'];
    $tweet = Tweet::loadTweetById($connection, $tweetId);
    $tweetText = $tweet->getText();
    $tweetUserId = $tweet->getUserId();
    echo "<h2>Edytowany wpis: </h2>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tweetText']) && !isset($_POST['delete'])) {
    $tweetId = $_GET['tweetId'];
    $tweet = Tweet::loadTweetById($connection, $tweetId);
    $tweetUserId = $tweet->getUserId();
    if ($tweetUserId == $_SESSION['id']) {
        $tweet = Tweet::loadTweetById($connection, $tweetId);
        $tweet->setText($_POST['tweetText']);
        $tweet->save($connection);
        echo 'Tweet został zmieniony';
        $tweetText = $_POST['tweetText'];

    } else {
        echo 'Nie mozesz edytowac nie swojego wpisu!';
        $tweetText = null;
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $tweetId = $_GET['tweetId'];
    $tweet = Tweet::loadTweetById($connection, $tweetId);
    $tweetUserId = $tweet->getUserId();
    if ($tweetUserId == $_SESSION['id']) {
        $test = $tweet->delete($connection);
        echo 'Twój wpis został usunięty';
        $tweetText = null;
    } else {
        echo 'Nie mozesz usuwać nie swojego wpisu!';
        $tweetText = null;
    }
}
?>
<html>
<body>
<form method="post">
    <br>
    <br><textarea name="tweetText" cols="35" rows="3"><?php
        echo $tweetText;
        ?></textarea>
    <br>
    <button type="submit">Edytuj</button>
    <br>
    <br>
    <button type="submit" name="delete" value=true>Usuń wpis</button>
    <br>
    <br>
</form>
</body>
</html>
