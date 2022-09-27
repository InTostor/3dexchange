<?php

$can_register=false;

$username_given=$_POST['username'];
$password_given=$_POST['password'];
$email_given=$_POST['email'];
$telephone_given=$_POST['tel'];
$location_given=$_POST['location'];

$can_register = isUserExists($username_given);
    



if ($can_register){
$conn = getDBconnection();
$stmt = $conn->prepare('INSERT INTO table_name (username, password, register_date, email, phone_number,location)
VALUES (?, ?, ?, ?, ?, ?); ');
$stmt->bind_param("ss", $username_given, $password_given);
$stmt->execute();
$stmt->close();
$conn->close();
}

foreach ($_POST as $val){
    echo "$val <br>";
}

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
                <input class="form_input" type="text" name="username" required placeholder="имя пользователя*">
                <input class="form_input" type="password" name="password" pattern=".{8,}" required placeholder="пароль*">
                (пароль должен быть длиннее 8 символов)
                <input class="form_input" type="email" name="email" placeholder="email">
                <input class="form_input" type="tel"  maxlength="12" name="tel"  placeholder="номер телефона">
                <input class="form_input" type="text"  name="location"  placeholder="страна/город">

                <input class="form_input register" type="submit" name="register" value="Зарегестрироваться">




        </div>

        <div class="form_inner">

        
            </form>
        </div>

    </div>


</body>

</html>