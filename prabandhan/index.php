<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
session_set_cookie_params(0);
session_start();
if (isset($_SESSION['ClassUser'])){
$usr = $_SESSION['ClassUser'];
}else{
    $usr = new User();
}
$perms = $usr->getPermissions();
echo "<pre>"; 
print_r($perms);
echo "</pre>";

?>
प्रबंधन(hindi) - management,administration (prabandhan)