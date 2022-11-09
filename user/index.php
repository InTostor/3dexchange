<?php
// setting environment
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
require_once "$ROOT/resources/php/classes/User.php";
require_once "$ROOT/resources/php/classes/Realization.php";



if (isset($_GET['id'])){
$user_id = $_GET['id'];
$username = getUsernameById($user_id);
}elseif(isset($_GET['username'])){
    $username = $_GET['username'];
    $user_id = getUserIdByUsername($username);
    
}else{
    raiseHttpError(400);
    die();
}
$usr = new User();
$usr->constructWithUsername($username);

$avatar_url = $usr->getAvatarUrl();

$username = $usr->getUsername();
$register_date = $usr->getRegisterDate();
$email = $usr->getEmail();
$phone_number = $usr->getPhone();
// $access_level = $usr->getAcc(); INOP
$description_md = $usr->getDescription();
$mood = $usr->getMood();
$location = $usr->getLocation();
getHTMLstuff();

$title = "3DE | пользователь $username";

include "page.php";
