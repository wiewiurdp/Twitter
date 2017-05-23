<?php

include_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $senderId = $_SESSION['id'];
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Index</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" media="screen"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
                <a class="btn btn-info" href="index.php?menu=messages&type=new" role="button">Nowa Wiadomość</a>
                <a class="btn btn-info" href="index.php?menu=messages&type=received" role="button">Odebrane</a>
                <a class="btn btn-info" href="index.php?menu=messages&type=send" role="button">Wysłane</a>
            </div>
        </div>
        <div class="row">

<?php
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'new':
            include_once 'admin/newMessage.php';
            break;
        case 'received':
            include_once 'admin/receivedMessages.php';
            break;
        case 'send':
            include_once 'admin/sendMessages.php';
            break;
    };
} elseif
    (isset($_GET['messageId'])){
    include_once 'admin/showMessage.php';

}
