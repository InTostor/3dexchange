<?php
// setting environment
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";




$avatar_url = "avatar.jpg";

$userid = $_GET['id'];


$conn = new mysqli($db_server, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM users where idusers=$userid";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


try {
} catch (Exception $ex) {
} finally {
    $conn->close();
}





if ($row == null and !$is_development) {

    http_response_code(404);
    include("$ROOT/404.php"); // provide your own HTML for the error page
    die();
}else{
$username = $row['username'];
$register_date = $row['register_date'];
$email = $row['email'];
$phone_number = $row['phone_number'];
$access_level = $row['access_level'];
$description_md = $row['description_md'];
$mood = $row['mood'];
$location = $row['location'];
getHTMLstuff();

include "page.php";
}