<?php

include_once __DIR__ . '/../bootstrap.php';

$receiverId = $_SESSION['id'];
$unreadMessages = Message::loadUnreadMessagesByReceiverId($connection, $receiverId);
usort($unreadMessages, 'descCreationDateSorter');
echo '<h2>Wiadomości nie przeczytane</h2>';
for ($i = 0; $i < count($unreadMessages); $i++) {
    $senderId = $unreadMessages[$i]->getSenderId();
    $user = User::loadUserById($connection, $senderId);
    $username = $user->getUsername();
    $topic = $unreadMessages[$i]->getTopic();
    $text = $unreadMessages[$i]->getText();
    $messageId = $unreadMessages[$i]->getId();
    $creationDate = $unreadMessages[$i]->getCreationDate();
    echo(sprintf('<a href="/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/index.php?menu=messages&messageId=%d"><b>Nadawca:</b> %s <b>Temat:</b> %s <b>Otrzymane: </b>%s<br></a>', $messageId, $username, $topic, $creationDate));

}
$unreadMessages = Message::loadReadMessagesByReceiverId($connection, $receiverId);
usort($unreadMessages, 'descCreationDateSorter');
echo '<h2>Wiadomości przeczytane</h2>';
for ($i = 0; $i < count($unreadMessages); $i++) {
    $senderId = $unreadMessages[$i]->getSenderId();
    $user = User::loadUserById($connection, $senderId);
    $username = $user->getUsername();
    $topic = $unreadMessages[$i]->getTopic();
    $text = $unreadMessages[$i]->getText();
    $messageId = $unreadMessages[$i]->getId();
    $creationDate = $unreadMessages[$i]->getCreationDate();
    echo(sprintf('<a href="/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/index.php?menu=messages&messageId=%d"><b>Nadawca:</b> %s <b>Temat:</b> %s <b>Otrzymane: </b>%s<br></a>', $messageId, $username, $topic, $creationDate));

}
