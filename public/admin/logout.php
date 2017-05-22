<?php
// public/admin/logout.php
include_once __DIR__.'/../bootstrap.php';

//if (isset($_SESSION['logged']) && isset($_SESSION['user']) && $_SESSION['logged'] == true) {
//    echo('Jesteś zalogowany jako ' . $_SESSION['user']);
//} else {
//    header('Location:login.php');
//    die();
//};

$_SESSION['logged'] = false;
