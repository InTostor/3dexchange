<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/Validator.php");
session_set_cookie_params(0);
session_start();

$usr = $_SESSION['ClassUser'];

$assoc = $usr->getAssocData()[0];



if (isset($_REQUEST['confirm_password_change'])){

    $continue=false;



    if ($_REQUEST['new_password']===$_REQUEST['confirm_password']){ // check password match
       
        $continue = $usr->checkPassword(md5($_REQUEST['curr_password'])); // check old password
    }else{
        $message =  "password mismatch";
    }
    if (strlen($_REQUEST['new_password'])<8){ //check length
        $message = "too short password";
        $continue=false;
    }

    if ($continue){
        $usr->updatePassword(md5($_REQUEST['new_password']));
        $message = "ok";
        
    }else{
        $message =  "wrong password";
    }

}

if (isset($_REQUEST['confirm_value_change'])){
    $r=$_REQUEST;
    Database::executeStmt(
    "UPDATE users SET email=?,phone_number=?,description_md=?,mood=?,location=? where idusers = $usr->id",
    "sssss",
    [$r['email'],
    $r['phone_number'],
    Validator::sanitizeUserInput($r['description_md']),
    $r['mood'],
    $r['location']
]);

}



$email = $usr->getEmail();
$phone_number = $usr->getPhone();
$desc = $usr->getDescription();
$mood = $usr->getMood();
$location = $usr->getLocation();
?>

<form action="" method="post" id="change_values">

<p>----email-----<input maxlength="4096" type="email" name="email" required placeholder="Текст на странице аккаунта в формате html" value=<?=$email?>></p>
<p>---телефон----<input  maxlength="4096" type="phone" name="phone_number" required placeholder="Текст на странице аккаунта в формате html"value=<?=$phone_number?>></p>
<p>---описание---<textarea  maxlength="4096" type="text" name="description_md" required placeholder="Текст на странице аккаунта в формате html"><?=$desc?></textarea></p>
<p>----статус----<textarea  maxlength="4096" type="text" name="mood" required placeholder="Текст на странице аккаунта в формате html"><?=$mood?></textarea></p>
<p>Местоположение<input  maxlength="4096" type="text" name="location" required placeholder="Текст на странице аккаунта в формате html"value=<?=$location?>></textarea></p>
    <input  type="submit" name="confirm_value_change" value="применить">
</form>

<form action="" method="post" id="change_password">
<input  maxlength="256" type="password" name="curr_password" required placeholder="текущий пароль">
<input  maxlength="256" type="password" name="new_password" required placeholder="новый пароль">
<input  maxlength="256" type="password" name="confirm_password" required placeholder="подтверждение пароля">
<input  type="submit" name="confirm_password_change" value="применить">
</form>