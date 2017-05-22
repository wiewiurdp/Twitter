<?php

include_once __DIR__ . '/../bootstrap.php';
$allUsers = User::loadAllUser($connection);
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $user = User::loadUserById($connection, $_POST['id']);
$username = $user->getUsername();
    $tweets = Tweet::showAllTweetsByUserId($connection, $_POST['id']);
    usort($tweets, 'descCreationDateSorter');
    echo '
<h1> Wszystkie tweety użytkownika <br><br>'
        .$username.'<br><br></h1>';
    for ($i = 0; $i < count($tweets); $i++) {
        $text = $tweets[$i]->getText();
        $creationDate = $tweets[$i]->getCreationDate();
        echo('<br><h2>'.$text . "<br></h2><code>Data dodania:" . $creationDate . "</code><br>");

        $tweetId = $tweets[$i]->getId();
        $comments = Comment::loadAllCommentsByTweetId($connection, $tweetId);
        if (!empty($comments)) {
            usort($comments, 'ascCreationDateSorter');
            echo '<br><br>Komentarze: ';
            for ($j = 0; $j < count($comments); $j++) {
                $commentUserId = $comments[$j]->getUserId();
                $commentUser = User::loadUserById($connection, $commentUserId);
                $commentUsername = $commentUser->getUsername();
                $commentText = $comments[$j]->getText();
                $commentCreationDate = $comments[$j]->getCreationDate();
                echo "<br><br><b>" . $commentUsername . "</b><br>" . $commentText . "<br>Data dodania:" . $commentCreationDate . "</code><br>";
            };
        };
    };
    die;
}
?>

<html>
<body>
<h1>Wybierz użytkownika</h1>
<form method="post" action="">
    <select name="id">
        <?php
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
