<?php
session_start();
setcookie("logged_as","null", time()+60*60*24*3, '/');
setcookie("logged_with","null", time()+60*60*24*3, '/');
$_SESSION['ClassUser'] = null ; 
header('location: /account');
session_destroy();

?>