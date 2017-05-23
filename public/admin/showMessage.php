<?php

include_once __DIR__ . '/../bootstrap.php';

$message = Message::loadMessageById($connection, $_GET['messageId']);
$receiverId = $message->getReceiverId();
$senderId = $message->getSenderId();
$user = User::loadUserById($connection, $senderId);
$username = $user->getUsername();
$topic = $message->getTopic();
$text = $message->getText();
$creationDate = $message->getCreationDate();
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['messageId']) && ($_SESSION['id'] == $senderId || $_SESSION['id'] == $receiverId)) {
    $message->setReadCheck(0);
    $message->save($connection);
    echo (sprintf("<b>Od: %s</b><h2>Temat: %s</h2><br>%s<br><br><code>%s</code>",$username,$topic, $text, $creationDate));

} else {
   echo "Nie możesz czytac nie swoich wiadomości!";
}