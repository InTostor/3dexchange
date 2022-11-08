<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
User::forget();
header("location:".$_SERVER['HTTP_REFERER']);

?>