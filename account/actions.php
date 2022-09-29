<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

if (!isLogged()){
    raiseHttpError(401);
    die();
}

function deleteUser(){
    $conn=getDBconnection();
    $stmt = $conn->prepare('INSERT INTO users (username, password, register_date, email, phone_number,location)
VALUES (?, ?, ?, ?, ?, ?); ');
$stmt->bind_param("ssisss", $username_given, md5($password_given),time(),$email_given,$telephone_given,$location_given);
$stmt->execute();
$stmt->close();
$conn->close();
}


?>