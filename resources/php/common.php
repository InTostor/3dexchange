<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
include "$ROOT/settings/settings.php";


function isUserExists($username){
    $conn = getDBconnection();
    $stmt = $conn->prepare('SELECT idusers FROM users where username = ?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row!=null){
        return true;
    }else{
        return false;
    }
}


function isLogged(){
    $is_logged = false;
    if (isset($_COOKIE['logged_as']) and isset($_COOKIE['logged_with'])){
        $is_logged = $_COOKIE['logged_as']!="null" and $_COOKIE['logged_with']!="null";
    }
    return $is_logged and isLegitLogin();
}

function isLegitLogin(){
    $conn = getDBconnection();
    $username_given = $_COOKIE["logged_as"];
    $password_given = $_COOKIE["logged_with"];
    $stmt = $conn->prepare('SELECT idusers FROM users where username = ? and password = ?');
    $stmt->bind_param("ss", $username_given, $password_given);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row!=null){
        $is_legit = true;
    }else{
        $is_legit = false;
    }
    $stmt->close();
    $conn->close();
    return $is_legit;
}



function getDBconnection(){
    global $db_server;
    global $db_database;
    global $db_username;
    global $db_password;
    $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
    return $conn;
}


function getHTMLstuff(){
    echo '<script src="/resources/js/common.js"></script>';
    echo '<link rel="stylesheet" href="/resources/css/common.css">';
    echo '<link rel="stylesheet" href="/resources/elements/header.css">';
    echo '<link rel="stylesheet" href="/resources/elements/footer.css">';
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />';
}


?>