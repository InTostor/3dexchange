<?php
// user related functions

function getUserIdByUsername($username){
    $conn = getDBconnection();

    $stmt = $conn->prepare('SELECT idusers FROM users where username = ?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    if ($row!=null){
        return $row["idusers"];
    }else{
        return 0;
    }
}


function getUsernameById(int $id){
    $conn = getDBconnection();
    $stmt = $conn->prepare('SELECT username FROM users where idusers = ?');
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    if ($row!=null){
        return $row["username"];
    }else{
        return 0;
    }
}






?>