<?php

include_once __DIR__ . '/../bootstrap.php';
$user = User::loadUserById($connection, $_SESSION['id']);
$username = $user->getUsername();
$email = $user->getEmail();
printf('<br><br><b>Nazwa użytkownika:</b> %s<br><br> <b>Email: </b>%s <br><br>', $username, $email, 0);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['password']) & isset($_POST['passwordCheck'])) {
    if ($_POST['password'] === $_POST['passwordCheck'] && password_verify($_POST['oldPassword'], $user->getHashPassword())) {
        $user->setHashPassword($_POST['password']);
        $user->save($connection);
    } else {
        echo '<b>Zle dane!</b>';
    }
}


?>
<html>
<body>
<form method="post">
    Wpisz obecne hasło: <br><input name="oldPassword" type="password">
    <br>
    Nowe Hasło: <br><input name="password" type="password">
    <br>
    Powtórz nowe haslo <br><input name="passwordCheck" type="password">
    <br>
    <br>
    <button type="submit">Zmień hasło</button>
    <br>
</form>
</body>
</html>