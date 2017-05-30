<?php
// public/admin/login.php
$loginCheck = 1;
include_once __DIR__.'/../bootstrap.php';
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
            header("Location:../index.php?menu=index");
        } else {
            $errors[] = 'Hasło niepoprawne';
        }
    } else {
        $errors[] = 'Brak takiego użytkownika';
    }
};
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
       <a href="../../public/admin/addUser.php">Rejejestracja</a>
</form>
</body>
</html>
