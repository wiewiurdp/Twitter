<?php
// public/admin/logout.php
$_SESSION['logged'] = false;
header('Location:login.php');