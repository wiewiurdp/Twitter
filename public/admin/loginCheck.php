<?php
if (!isset($loginCheck)) {
    if (isset($_SESSION['logged']) && isset($_SESSION['email']) && $_SESSION['logged'] == true) {
        echo('Jesteś zalogowany jako ' . $_SESSION['email']);
    } else {
        if (strpos($_SERVER['PHP_SELF'], "/admin/") != false) {
            header("Location:../admin/login.php");
        } else {
            header("Location:../public/admin/login.php");
        }
    }
};