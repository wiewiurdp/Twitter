<?php
// public/admin/logout.php
session_start();
$_SESSION['logged'] = false;
$_SESSION['email'] = false;
$_SESSION['id'] = false;
header('Location:login.php');