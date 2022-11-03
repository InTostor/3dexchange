<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";


$can_register=false;

if (isset($_POST['register'])){
$username_given=$_POST['username'];
$password_given=$_POST['password'];
$email_given=nullIfNone($_POST['email']);
$telephone_given=nullIfNone($_POST['tel']);
$location_given=nullIfNone($_POST['location']);

$can_register = !isUserExists($username_given);
    
}



function nullIfNone($chk){
    if ($chk==""){
        return "null";
    }else{
        return $chk;
    }
}


if ($can_register ){
$conn = getDBconnection();
$stmt = $conn->prepare('INSERT INTO users (username, password, register_date, email, phone_number,location)
VALUES (?, ?, ?, ?, ?, ?); ');
$stmt->bind_param("ssisss", $username_given, md5($password_given),time(),$email_given,$telephone_given,$location_given);
$stmt->execute();
$stmt->close();
$conn->close();

rememberUser($username_given,md5($password_given));

header('location: /account/welcome.php');
}


echo $can_register? ' можно ' : ' нельзя ';
?>



<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/css/common.css">
    <link rel="stylesheet" href="/account/register.css">
</head>

<body>

    <div class="form">
        <div class="form_upper">
            <h1 class="form_header">Зарегестироваться</h1>
            <a class="back" href="/">на главную</a>
        </div>
        <div class="form_inner">

            <form action="" method="post" id="register" class="register_form">
                *обязательно
                <input class="form_input" type="text" name="username" required placeholder="псевдоним*">
                <input class="form_input" type="password" name="password" pattern=".{8,}" required placeholder="пароль*">
                (пароль должен быть длиннее 8 символов)
                <input class="form_input" type="email" name="email" placeholder="email">
                <input class="form_input" type="tel"  maxlength="12" name="tel"  placeholder="номер телефона">
                <input class="form_input" type="text"  name="location"  placeholder="страна/город">

                <input class="form_input register" type="submit" name="register" value="Зарегестрироваться">
                <p>нажимая кнопку "зарегестрироваться", вы принимаете: <a href="/documents/EULA.txt">пользовательское соглашение</a>,<br>
                <a href="/documents/rules.txt">правила</a><br> и <a href="/documents/privacy_policy">политику конфиденциальности</a></p>
                <?php
                    if (!$can_register and isset($_POST['register']) ){
                        echo "<h3 style='color:red;'>Невозможно зарегестрироваться: этот пользователь уже существует </h3>";
                    }


                ?>
                </form>



        </div>



    </div>


</body>

</html>