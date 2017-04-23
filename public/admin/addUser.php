<?php

include_once '../connection.php';
include_once '../autoload.php';

$user = new User();
$user->setEmail('tt@tt.pl');
$user->setUsername('test');
$user->setHashPassword('password');

$result = $user->save($connection);
echo 'Mamy usera';
