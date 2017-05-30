<?php

include_once __DIR__ . '/../bootstrap.php';
$allUsers = User::loadAllUser($connection);
usort($allUsers,'ascUsernameSorter');
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id']) && !empty($_POST['id'])) {
    $user = User::loadUserById($connection, $_POST['id']);
    $username = $user->getUsername();
    $tweets = Tweet::showAllTweetsByUserId($connection, $_POST['id']);
    usort($tweets, 'descCreationDateSorter');
    echo '
<h1> Wszystkie tweety użytkownika <br><br>'
        . $username . '<br><br></h1>';
    for ($i = 0; $i < count($tweets); $i++) {
        $tweetId = $tweets[$i]->getId();
        $tweetText = $tweets[$i]->getText();
        $tweetCreationDate = $tweets[$i]->getCreationDate();
        echo "<b><h2><a href='../public/index.php?menu=tweet&tweetId=" . $tweetId . "'></b><br>" . $tweetText . "</a><br></h2><code>Data dodania:" . $tweetCreationDate . "</code>";

        $tweetId = $tweets[$i]->getId();
        $comments = Comment::loadAllCommentsByTweetId($connection, $tweetId);
        if (!empty($comments)) {
            usort($comments, 'ascCreationDateSorter');
            echo '<br><br>Komentarze: ';
            for ($j = 0; $j < count($comments); $j++) {
                $commentId = $comments[$j]->getId();
                $commentUserId = $comments[$j]->getUserId();
                $commentUser = User::loadUserById($connection, $commentUserId);
                $commentUsername = $commentUser->getUsername();
                $commentText = $comments[$j]->getText();
                $commentCreationDate = $comments[$j]->getCreationDate();
//                echo "<br><br><b>" . $commentUsername . "</b><br>" . $commentText . "<br>Data dodania:" . $commentCreationDate . "</code><br>";
                echo "<br><br><b>" . $commentUsername . "<a href='../public/index.php?menu=comment&commentId=" . $commentId . "'></b><br>" . $commentText . "</a><br><code>Data dodania:" . $commentCreationDate . "</code>";

            };
        };
    };
    die;
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id']) && empty($_POST['id'])){
    echo '<b>Zly input!</b>';
}
?>

<html>
<body>
<h1>Wybierz użytkownika</h1>
<form method="post" action="">
    <select name="id">
        <?php
        echo "<option value=''>- -</option>";
        for ($i = 0; $i < count($allUsers); $i++) {
            $user = $allUsers[$i]->getUsername();
            $id = $allUsers[$i]->getId();
            echo "<option value='$id'>$user</option>";
        }
        ?>
    </select>
    <br>
    <br>
    <button type="submit">Pokaz wszystkie tweety.</button>
</form>
</body>
</html>
