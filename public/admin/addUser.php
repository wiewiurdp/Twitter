<?php
// public/admin/addUser.php
$loginCheck = 1;
include_once __DIR__ . '/../bootstrap.php';
if (!($_SERVER["REQUEST_METHOD"] === "POST")) {

} else {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) & isset($_POST['passwordCheck'])) {
        if ($_POST['password'] === $_POST['passwordCheck']) {
            $email = $_POST['email'];
            $emailCheck = User::showUserByEmail($connection, $email);
            if ($emailCheck) {
                echo 'Istnieje już użytkownik o podanym emailu.';
            } else {
                $user = new User();
                $user->setEmail($_POST['email']);
                $user->setUsername($_POST['username']);
                $user->setHashPassword($_POST['password']);
                $result = $user->save($connection);
                die ('
        Użytkownik został dodany<br>
        <a href=login.php>Przejdz do logowania</a>
        ');
            }
        } else {
            echo 'Wprowadzone hasła powinny być identyczne';
        }
    } else {
        echo 'Zle dane';
    }
}
?>

<html>
<body>
<h1>Stwórz nowego użytkownika</h1>
<form method="post">
    Nazwa użytkownika: <br><input name="username">
    <br>
    Email: <br><input name="email" type="email">
    <br>
    Hasło: <br><input name="password" type="password">
    <br>
    Powtórzone haslo <br><input name="passwordCheck" type="password">
    <br>
    <br>
    <button type="submit">Rejestruj</button>
    <br>

</form>
</body>
</html>
