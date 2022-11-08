<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/resources/php/classes/User.php";
// there should be loading of required script for this situation (no account/logged/other)
// $usrPage = "acc"
// header("Location:".$usrPage);

$is_logged = false;
$is_logged = false;


if (isset($_COOKIE['logged_as']) and isset($_COOKIE['logged_with'])){
    $is_logged = $_COOKIE['logged_as']!="null" and $_COOKIE['logged_with']!="null";
}

if ($is_logged == true) {
    require "./logged.php";

} else {
    require "./login.php";
}


?>