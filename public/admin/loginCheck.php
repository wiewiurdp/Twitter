<?php
if (!isset($loginCheck)) {
    if (isset($_SESSION['logged']) && isset($_SESSION['email']) && $_SESSION['logged'] == true) {
        echo('Jesteś zalogowany jako ' . $_SESSION['email']);
    } else {
        header("Location:/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/admin/login.php");
    }
};