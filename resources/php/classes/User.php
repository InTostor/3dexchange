<?php

class User {

    public $username;
    public $id;
    public $access_level;
    public $last_login_date;
    public $exists;
    private $email;
    private $phone;

    function constructWithId(int $id){
        $this->id = $id;
        $this->username=$this->getUsernameById($id);
        $this->exists = $this->isExists();
    }
    function constructWithUsername(int $username){
        $this->username = $username;
        $this->id=$this->getUserIdByUsername($username);
        $this->exists = $this->isExists();
    }
    
    function consturctWithCurrentLogin(){

        function isLogged(){
            $is_logged = false;
            if (isset($_COOKIE['logged_as']) and isset($_COOKIE['logged_with'])){
                $is_logged = $_COOKIE['logged_as']!="null" and $_COOKIE['logged_with']!="null";
                return $is_logged and isLegitLogin();
            }else{
                return false;
            }
            
        }        
        function getLoggedAs(){
            if (isset($_COOKIE['logged_as'])){
            return $_COOKIE['logged_as'];
            }else{
                return "null";
            }
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
            $stmt->close();
            $conn->close();
            if ($row!=null){
                $is_legit = true;
            }else{
                $is_legit = false;
            }        
            return $is_legit;
        }
        $logged = isLogged();
        if ($logged){
            $this->username = getLoggedAs();
            $this->id=$this->getUserIdByUsername($this->username);
            $this->exists = $this->isExists();
        }

        return $logged;
    }
    
// ! remember that user view is in /user and user editing in /account/actions.php

    function getViewUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        return "/user?view&id=$this->id";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
        return "$r/user?view&id=$this->id";
        }
    }
    
    function geteditUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        // return "/user?edit&id=$this->id";
        return "/account/actions.php";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
        // return "$r/user?edit&id=$this->id";
        return "$r/account/actions.php";
        }
    }



    function checkPermisiion(string $permission){
        return true;
    }

    function isExists(){
        $conn = getDBconnection();
        $stmt = $conn->prepare("select idusers from users where idusers=?");
        $stmt->bind_param("i",$this->id);

        if ($stmt->get_result()->fetch_assoc()['idusers']=="null" ){
            $this->exists = false;
        }else{
            $this->exists = true;
        }
        $stmt->close();
        $conn->close();
    }


    function getAvatar():string{
        return "";
    }

    function getEmail(){
        if (isset($this->email)){
            return $this->email;
        }else{
            $conn = getDBconnection();
            $stmt = $conn->prepare("select email from users where idusers=?");
            $stmt->bind_param("i",$this->id);
            $stmt->execute();
            $this->email = $stmt->get_result()->fetch_assoc()['email'];
            $stmt->close();
            $conn->close();
            return $this->email;
        }
    }
    function getPhone(){
        if (isset($this->phone)){
            return $this->phone;
        }else{
            $conn = getDBconnection();
            $stmt = $conn->prepare("select phone_number from users where idusers=?");
            $stmt->bind_param("i",$this->id);
            $stmt->execute();
            $this->phone = $stmt->get_result()->fetch_assoc()['phone_number'];
            $stmt->close();
            $conn->close();
            return $this->phone;
        }
    }


    function make(){

        if (!($this->isExists())){
            $conn=getDBconnection();
            $stmt = $conn->prepare("insert into users (username,password,register_date,email,phone_unmber) values(?,?,?,?,?)");
        }else{
            return false;
        }

    }

    private function getUserIdByUsername($username){
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
    
    
    private function getUsernameById(int $id){
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
    



}