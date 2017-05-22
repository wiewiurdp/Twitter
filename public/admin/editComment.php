<?php

include_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];
    $comment = Comment::loadCommentById($connection, $commentId);
    $commentText = $comment->getText();
    $commentUserId = $comment->getUserId();
    echo "<h2>Edytowany komentarz: </h2>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['commentText']) && !isset($_POST['delete'])) {
    $commentId = $_GET['commentId'];
    $comment = Comment::loadCommentById($connection, $commentId);
    $commentUserId = $comment->getUserId();
    $commentTweetId = $comment->getTweetId();
    $tweet = Tweet::loadTweetById($connection, $commentTweetId);
    $tweetUserId = $tweet->getUserId();
    if ($commentUserId == $_SESSION['id']) {
        $comment = Comment::loadCommentById($connection, $commentId);
        $comment->setText($_POST['commentText']);
        $comment->save($connection);
        echo 'Komentarz został zmieniony';
        $commentText = $_POST['commentText'];

    } else {
        echo 'Nie mozesz edytowac nie swojego komentarza!';
        $commentText = null;
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $commentId = $_GET['commentId'];
    $comment = Comment::loadCommentById($connection, $commentId);
    $commentUserId = $comment->getUserId();
    $commentTweetId = $comment->getTweetId();
    $tweet = Tweet::loadTweetById($connection, $commentTweetId);
    $tweetUserId = $tweet->getUserId();
    if ($commentUserId == $_SESSION['id'] || $tweetUserId == $_SESSION['id']) {
        $test = $comment->delete($connection);
        echo 'Ten komentarz został usunięty';
        $commentText = null;
    } else {
        echo 'Nie mozesz usuwać nie swojego komentarza!';
        $commentText = null;
    }
}
?>
<html>
<body>
<form method="post">
    <br>
    <br><textarea name="commentText" cols="35" rows="3"><?php
        echo $commentText;
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
