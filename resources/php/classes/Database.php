<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/settings/settings.php";

 function getDB(){
    global $db_server;
    global $db_database;
    global $db_username;
    global $db_password;
    $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
    return $conn;
}

Class Database {
    

    static function updateField($table,$field,$where,$is,$value){

        $conn=getDB();
        $stmt = $conn->prepare("UPDATE $table SET  $field = ? WHERE ($where = ?)");
        $stmt->bind_param("ss",$value,$is);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    static function select($table,$where,$is){
        
        $conn=getDB();
        $stmt = $conn->prepare("SELECT * FROM $table WHERE $where = ?");
        $stmt->bind_param("s",$is);
        $stmt->execute();        
        $result = $stmt->get_result();

        
        $res = [];
        
        while($row = $result->fetch_assoc()) {


            $res[] = $row;
            
        }
        $stmt->close();
        $conn->close();
        return $res;
    }




}


?>
