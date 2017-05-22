<?php

include_once __DIR__ . '/../bootstrap.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tweetText'])) {
 $newTweet = new Tweet();
 $newTweet->setUserId($_SESSION['id']);
 $newTweet->setText($_POST['tweetText']);
 $newTweet->setCreationDate(date("Y-m-d H:i:s"));
 $newTweet->save($connection);
 echo 'Twój tweet został dodany';
}
?>

<html>
<body>
<form method="post">
    <br>
    <br><textarea name="tweetText" cols="35" rows="3" placeholder="O czym tera myślisz?"></textarea>
    <br>
    <button type="submit">Tweetuj</button>
    <br>
    <br>
</form>
</body>
</html>
