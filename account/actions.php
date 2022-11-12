
<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/css/common.css">
    <link rel="stylesheet" href="/user/index.css">
    <title>3DE | редактирование профиля</title>
</head>

<script>
    function getContent(){
        var el = document.getElementById("fcDesc")
        el.value = (document.getElementById("currDesc").innerHTML).replace('\n','<br>')
    }
</script>

<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/File.php");
require_once("$ROOT/resources/php/classes/Validator.php");
session_set_cookie_params(0);
session_start();
if (isset($_SERVER['HTTP_REFERER']) and isset($_COOKIE['came_from'])){
    setcookie("came_from",$_SERVER['HTTP_REFERER'], time()+180, '/');
    $retUrl = $_COOKIE['came_from'];
}

$usr = $_SESSION['ClassUser'];

$avatar_url = $usr->getAvatarUrl();

$username = $usr->getUsername();
$register_date = $usr->getRegisterDate();
$email = $usr->getEmail();
$phone_number = $usr->getPhone();
// $access_level = $usr->getAcc(); INOP
$description_md = $usr->getDescription();
$mood = $usr->getMood();
$location = $usr->getLocation();


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

if (isset($_REQUEST['confirm_avatar_change'])){

    $usr->updateAvatar($_FILES["avatar_file"]["tmp_name"]);
    File::cleanTempShit("$ROOT/account");
}





$email = $usr->getEmail();
$phone_number = $usr->getPhone();
$desc = $usr->getDescription();
$mood = $usr->getMood();
$location = $usr->getLocation();
?>

<?php if (isset($retUrl)){
    echo "<a href=$retUrl>вернуться</a>";
}else{
    echo "<a href=/account>вернуться</a>";
}
    ?>

<form action="" method="post" id="change_values" onsubmit = "return getContent()">
<p>----email-----<input maxlength="4096" type="email" name="email" id="fcName" required placeholder="Текст на странице аккаунта в формате html" value=<?=$email?>></p>
<p>---телефон----<input  maxlength="4096" type="phone" name="phone_number" id="fcPhone" required placeholder="Текст на странице аккаунта в формате html"value=<?=$phone_number?>></p>
<p>---описание---<textarea style="display:none" maxlength="4096" type="text" name="description_md" id="fcDesc" required placeholder="Текст на странице аккаунта в формате html"><?=$desc?></textarea></p>
<p>----статус----<textarea  maxlength="4096" type="text" name="mood" id="fcMood" required placeholder="Текст на странице аккаунта в формате html"><?=$mood?></textarea></p>
<p>Местоположение<input  maxlength="4096" type="text" name="location" id="fcLoc" required placeholder="Текст на странице аккаунта в формате html"value=<?=$location?>></textarea></p>
    <input  type="submit" name="confirm_value_change" value="применить">
</form>

<form action="" method="post" id="change_avatar" enctype="multipart/form-data">
<input type="file" accept=".jpeg,.jpg,.png,.gif" name="avatar_file">
<input type="submit" name="confirm_avatar_change" value="изменить">
</form>


<form action="" method="post" id="change_password">
<input  maxlength="256" type="password" name="curr_password" required placeholder="текущий пароль">
<input  maxlength="256" type="password" name="new_password" required placeholder="новый пароль">
<input  maxlength="256" type="password" name="confirm_password" required placeholder="подтверждение пароля">
<input  type="submit" name="confirm_password_change" value="применить">
</form>




<div class="row">
    <div class="avatar">
        <img class="avatar_img" src=<?= "$avatar_url" ?>>
        <h1><span class="material-symbols-outlined smallIcon">handyman</span> <?= $username ?></h1>
        <h3><span class="material-symbols-outlined smallIcon">location_on</span> <?= $location ?></h3>
        <h4><span class="material-symbols-outlined smallIcon">cloud</span> <?= $mood ?></h4>

    </div>
    <div contenteditable="true" id="currDesc" class="description"><?=$description_md?></div>
</div>

