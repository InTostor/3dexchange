<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
session_set_cookie_params(0);
session_start();

$usr = $_SESSION['ClassUser'];
print_r($usr);
echo "<br>";
$assoc = $usr->getAssocData();
print_r($assoc);

