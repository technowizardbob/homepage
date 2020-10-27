<?php

session_start();

$user = $_SESSION['username'] ?? false;
if ($user === false) {
    $user = $_COOKIE['home'] ?? false;
}
$loggedin = ($user === false || empty($user)) ? false : true;

$man = $_GET['name'] ?? false;

$username = ($loggedin) ? $user : $man; 