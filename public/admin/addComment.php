<?php

include_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tweetId']) && isset($_POST['commentText']) && $_POST['tweetId'] == $tweetId) {
    $newComment = new Comment();
    $newComment->setTweetId($_POST['tweetId']);
    $newComment->setText($_POST['commentText']);
    $newComment->setCreationDate(date("Y-m-d H:i:s"));
    $newComment->setUserId($_SESSION['id']);
    $newComment->save($connection);
    echo ('<br>Twój komentarz został dodany');
}
?>
<html>
<body>
<form method="post">
    <br><textarea name="commentText" cols="35" rows="3" placeholder="Komentuj"></textarea>
    <br>
    <button type="submit" name="tweetId" value="<?php
    echo "$tweetId";
    ?>">Dodaj komentarz
    </button>
    <br>
    <br>
    <br>
    <br>

</form>
</body>
</html>