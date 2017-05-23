<?php

include_once __DIR__ . '/../bootstrap.php';

$sendMessages = Message::loadMessagesBySenderId($connection, $_SESSION['id']);
usort($sendMessages, 'descCreationDateSorter');
echo '<h2>Wiadomości wysłane</h2>';
for ($i = 0; $i < count($sendMessages); $i++) {
    $receiverId = $sendMessages[$i]->getReceiverId();
    $user = User::loadUserById($connection, $receiverId);
    $username = $user->getUsername();
    $topic = $sendMessages[$i]->getTopic();
    $text = $sendMessages[$i]->getText();
    $messageId = $sendMessages[$i]->getId();
    $creationDate = $sendMessages[$i]->getCreationDate();
    echo(sprintf('<a href="/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/index.php?menu=messages&messageId=%d"><b>Odbiorca:</b> %s <b>Temat:</b> %s <b>Otrzymane: </b>%s<br></a>', $messageId, $username, $topic, $creationDate));

}