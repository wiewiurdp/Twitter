<?php
// public/admin/addUser.php
include_once '../bootstrap.php';

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    die('użytkownik musi być zalogowany');
}

$user = new User();
$user->setEmail('tt@tt.pl');
$user->setUsername('test');
$user->setHashPassword('password');

$result = $user->save($connection);
echo 'Mamy usera';
