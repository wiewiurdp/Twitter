<?php

include_once __DIR__ . '/../bootstrap.php';

$allUsers = User::loadAllUser($connection);
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['type'])) {

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageText'])) {
    $newMessage = new Message();
    $newMessage->setSenderId($_SESSION['id']);
    $newMessage->setReceiverId($_POST['receiverId']);
    $newMessage->setTopic($_POST['topic']);
    $newMessage->setText($_POST['messageText']);
    $newMessage->setCreationDate(date("Y-m-d H:i:s"));
    $newMessage->setReadCheck(1);
    $newMessage->save($connection);
    echo 'Twoja wiadomość została wysłana';
}
?>

<html>
<body>
<h1>Napisz wiadomość</h1>
<form method="post">
   Do: <br>
    <select name="receiverId">
        <?php
        for ($i = 0; $i < count($allUsers); $i++) {
            $user = $allUsers[$i]->getUsername();
            $id = $allUsers[$i]->getId();
            echo "<option value='$id'>$user</option>";
        }
        ?>
    </select>
    <br>
    Temat: <input name="topic">
    <br>
    <br><textarea name="messageText" cols="60" rows="5" placeholder="O czym chcesz napisać?"></textarea>
    <br>
    <button type="submit">Wyślij</button>
    <br>

</form>
</body>
</html>