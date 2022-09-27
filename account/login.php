<?php
session_start();
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
$message="";

$username_given="";
$password_given="";

if (isset($_POST["login"])){
$username_given=$_POST['username'];
$password_given=$_POST['password'];


$conn = new mysqli($db_server, $db_username, $db_password, $db_database);
$stmt = $conn->prepare('SELECT idusers FROM users where username = ? and password = ?');
$stmt->bind_param("ss", $username_given, md5($password_given));
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ( $row!=null ){
    $message="found";
    rememberUser($username_given,$password_given);
    header("Refresh:0");
}else{
    $message="not_found";
}

$stmt->close();
$conn->close();

}

if(isset($_COOKIE["logged_as"])) {
echo $_COOKIE["logged_as"];

}


function rememberUser($user,$pass){
    setcookie("logged_as",$user, time()+60*60*24*3, '/');
    setcookie("logged_with",md5($pass), time()+60*60*24*3, '/');
}



?>


<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/css/common.css">
    <link rel="stylesheet" href="/account/login.css">
</head>

<body>

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
            </form>
        
            
    </div>
</div>


<?=$message?>
</body>
</html>