<?php
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();

$_SESSION['username'] = "";
$_SESSION['last'] = false;

session_destroy();

if (isset($_COOKIE['home'])) {
    unset($_COOKIE['home']);
    setcookie('home', '', time() - 3600, "/"); // empty value and old timestamp
}

echo "You are now logged out!";
