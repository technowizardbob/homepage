<?php

session_start();

$_SESSION['username'] = "";

session_destroy();

if (isset($_COOKIE['home'])) {
    unset($_COOKIE['home']);
    setcookie('home', '', time() - 3600); // empty value and old timestamp
}

echo "You are now logged out!";
