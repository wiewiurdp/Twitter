<?php
include_once 'bootstrap.php';

if (isset($_SESSION['logged']) && isset($_SESSION['email']) && $_SESSION['logged'] == true) {
    echo('Jesteś zalogowany jako ' . $_SESSION['email']);
} else {
    header('Location:admin/login.php');
};
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
                <a class="btn btn-warning" href="index.php?menu=index" role="button">Strona główna</a>
                <a class="btn btn-info" href="index.php?menu=users" role="button">Użytkownicy</a>
                <a class="btn btn-info" href="index.php?menu=messages" role="button">Wiadomości</a>
                <a class="btn btn-info" href="index.php?menu=myProfile" role="button">Profil</a>
                <a class="btn btn-info" href="admin/logout.php" role="button">Wyloguj się</a>
            </div>
        </div>
        <div class="row">

<?php
if (isset($_GET['menu'])) {
    switch ($_GET['menu']) {
        case 'index':
            include_once 'admin/addTweet.php';
            include_once 'admin/allTweets.php';
            break;
        case 'users':
            include_once 'admin/getUserTweets.php';
            break;
        case 'messages':
            include_once 'admin/getUserMessages.php';

            break;
        case 'myProfile':

            break;
        case 'tweet':
            include_once 'admin/editTweet.php';
            break;
        case 'comment':
            include_once 'admin/editComment.php';
            break;
    }
} else {

}
