<?php

include_once __DIR__ . '/../bootstrap.php';
$allUsers = User::loadAllUser($connection);
usort($allUsers, 'ascUsernameSorter');

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
<h1><?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageId'])) {
        echo 'Odpowiedz na wiadomość';
    } else {
        echo 'Napisz wiadomość';
    }
    ?>
</h1>
<form method="post" <?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageId'])) {
    echo "action='../public/index.php?menu=messages&type=new'";
}
?>
>
    Do: <br>
    <select name="receiverId">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageId'])) {
            $message = Message::loadMessageById($connection, $_POST['messageId']);
            $senderId = $message->getSenderId();
            $topic = $message->getTopic();
            $text = $message->getText();
            $senderUser = User::loadUserById($connection, $senderId);
            $senderUsername = $senderUser->getUsername();
            echo "<option value='$senderId'>$senderUsername</option>";
        } else {
            for ($i = 0; $i < count($allUsers); $i++) {
                $user = $allUsers[$i]->getUsername();
                $id = $allUsers[$i]->getId();
                echo "<option value='$id'>$user</option>";
            }
        }
        ?>
    </select>
    <br>
    Temat: <input name="topic" value="<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageId'])) {
        echo "Re: " . $topic;
    }
    ?>
">
    <br>
    <br><textarea name="messageText" cols="60" rows="5"><?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['messageId'])) {
            echo $text;
        }
        ?></textarea>
    <br>
    <button type="submit">Wyślij</button>
    <br>

</form>
</body>
</html>