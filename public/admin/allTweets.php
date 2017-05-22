<?php

include_once __DIR__ . '/../bootstrap.php';

echo '<h1>Wszystkie tweety</h1>';

$tweets = Tweet::showAllTweets($connection);
usort($tweets, 'descCreationDateSorter');
for ($i = 0; $i < count($tweets); $i++) {
    $tweetUserId = $tweets[$i]->getUserId();
    $tweetUser = User::loadUserById($connection, $tweetUserId);
    $tweetUsername = $tweetUser->getUsername();
    $tweetText = $tweets[$i]->getText();
    $tweetCreationDate = $tweets[$i]->getCreationDate();
    $tweetId = $tweets[$i]->getId();
    echo "<b><h2>". $tweetUsername ."<a href='/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/index.php?menu=tweet&tweetId=".$tweetId."'></b><br>" . $tweetText . "</a><br></h2><code>Data dodania:" . $tweetCreationDate . "</code>";




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
            $commentId = $comments[$j]->getId();
            echo "<br><br><b>" . $commentUsername . "<a href='/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/index.php?menu=comment&commentId=".$commentId."'></b><br>" . $commentText . "</a><br><code>Data dodania:" . $commentCreationDate . "</code>";
        };
    };
    include 'addComment.php';
};
?>