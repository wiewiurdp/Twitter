<?php
// public/admin/login.php
include_once __DIR__.'/../bootstrap.php';

if (isset($_SESSION['logged']) && isset($_SESSION['email']) && $_SESSION['logged'] == true) {
    die('Jesteś zalogowany jako '.$_SESSION['email']);
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['reg'])){
    $email = $_POST['email'];
    $password = User::hashPassword($_POST['password']);
    $user = User::showUserByEmail($connection, $email);
    if ($user) {
        if (password_verify($_POST['password'], $user->getHashPassword())) {
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['id'] = $user->getId();
            header("Location:../index.php");
        } else {
            $errors[] = 'Hasło niepoprawne';
        }
    } else {
        $errors[] = 'Brak takiego użytkownika';
    }
};
//else {
//    password_hash();
//}
?>

<html>
<body>
<h1>Zaloguj się</h1>
<form method="post">
    <?php echo join('<br>', $errors); ?>
    <br>
    Email: <input name="email">
    <br>
    Haslo: <input name="password" type="password">
    <br>
    <button type="submit">Loguj</button>
    <br>
       <a href="/KRA_PHP_W_02_Podstawy_Programowania/Warsztaty2/public/admin/addUser.php">Rejejestracja</a>
</form>
</body>
</html>
