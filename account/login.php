
<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/css/common.css">
    <link rel="stylesheet" href="/account/login.css">
    <script src="/resources/js/common.js"></script>
    <title>Вход в аккаунт</title>
</head>

<body>

<?php

$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/settings/settings.php";
require_once "$ROOT/resources/php/common.php";
require_once("$ROOT/resources/php/classes/User.php");

setcookie("came_from",$_SERVER['HTTP_REFERER'], time()+180, '/'); //allows to move user at 45 line (because of POST requests on page)

$message="";

$username_given="";
$password_given="";

if (isset($_POST["login"])){
    $username_given=$_POST['username'];
    $password_given=$_POST['password'];

    $canLogin = User::checkCredentials($username_given,$password_given,'raw');

    if ( $canLogin){
        $message="found"; // not good solution
        User::remember($username_given,md5($password_given));
        $usr = new User();
        $usr->constructWithUsername($username_given);
        session_set_cookie_params(0);
        session_start();
        $_SESSION['ClassUser'] = $usr;
        echo "<script>showMessage('Вход выполнен',2000)</script>";
        header("Refresh:2; url=".$_COOKIE['came_from']); //move user to place,where he came from
    }else{
        $message="not_found";
    }
}



?>




<div class="form">
    <div class="form_upper">
    <h1 class="form_header">Вход в аккаунт</h1>
    <a class="back" href="/">на главную</a>
    </div>
    <div class="form_inner">

            <form action="" method="post" id="login" class="login_form">
                <input class="form_input" type="text" name="username" required autofocus autocomplete="on" placeholder="логин/почта/телефон/id">
                <input class="form_input" type="password" name="password" required autocomplete="on" placeholder="пароль" >

                <input class="form_input login" type="submit" name="login" value="Войти">
                <h3 style="margin: auto;">или</h3>
                <a href="/account/register.php" class="form_input reg" >Зарегестироваться</a>
                <?php
                    if ($message=="not_found"){
                        echo "<h3 style='color:red;'>Неверное имя пользователя или пароль </h3>";
                    }

                ?>
            </form>
        
            
    </div>
</div>



</body>
</html>