<?php

require_once('../src/session.php');

if ( $_POST ) {

    if ( array_key_exists('cancel', $_POST) ) {
        header('Location: /');
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ( login($username, $password) ) {
        header("Location: /");
        exit;
    }
} else {
    if (isUserLoggedIn()) {
        header('Location: /');
        exit;
    }
}

?><!doctype html>
<html lang="en">
<?php $page_title = "Login"; require('../src/partials/head.php'); ?>
<body>
    <form method="post">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </p>
        <input type="submit" name="login" value="Login">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>