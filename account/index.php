<?php

use function PHPSTORM_META\type;

$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/resources/php/classes/User.php";


session_start();
if (isset($_SESSION['ClassUser'])){
$usr = $_SESSION['ClassUser'];
}else{
    $usr = new User();
}

$usrPage = $usr->getViewUrl($isSystemRoot = false,$type="username");
$is_logged = $usr->isLogged();


if ($is_logged == true) {
    header("Location:".$usrPage);
    // require "./logged.php";

} else {
    require "./login.php";
}


?>