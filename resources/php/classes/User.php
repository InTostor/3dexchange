<?php

require_once('Database.php');



class User {

    public $username;
    public $id;
    public $access_level;
    public $last_login_date;
    public $exists;
    private $email;
    private $phone;

// pack/unpack class for transfer

    public function __serialize(): array {
        return [
            'username' => $this->username,
            'id' => $this->id,
            'access_level' => $this->access_level,
            'last_login_date' => $this->last_login_date,
            'exists' => $this->exists,
            'email' => $this->email,
            'phone' => $this->phone,
        ];


    }

    public function __unserialize(array $data): void {
        $this->username = $data['username'];
        $this->id = $data['id'];
        $this->access_level = $data['access_level'];
        $this->last_login_date = $data['last_login_date'];
        $this->exists = $data['exists'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];

    }
// pack/unpack class for transfer

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

        function PisLogged(){
            $is_logged = false;
            if (isset($_COOKIE['logged_as']) and isset($_COOKIE['logged_with'])){
                $is_logged = $_COOKIE['logged_as']!="null" and $_COOKIE['logged_with']!="null";
                return $is_logged and PisLegitLogin();
            }else{
                return false;
            }
            
        }        
        function PgetLoggedAs(){
            if (isset($_COOKIE['logged_as'])){
            return $_COOKIE['logged_as'];
            }else{
                return "null";
            }
        }        
        function PisLegitLogin(){
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
        $logged = PisLogged();
        if ($logged){
            $this->username = PgetLoggedAs();
            $this->id=$this->getUserIdByUsername($this->username);
            // $this->exists = $this->isExists();
        }

        return $logged;
    }
    
// ! remember that user view is in /user and user editing in /account/actions.php

    function getViewUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        return "/user?view&id=$this->id";
        }else{
            $rt = $_SERVER['DOCUMENT_ROOT'];
        return "$rt/user?view&id=$this->id";
        }
    }
    
    function geteditUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        // return "/user?edit&id=$this->id";
        return "/account/actions.php";
        }else{
            $rt = $_SERVER['DOCUMENT_ROOT'];
        // return "$r/user?edit&id=$this->id";
        return "$rt/account/actions.php";
        }
    }



    function checkPermisiion(string $permission){
        return true;
    }

    function isExists(){
        $conn = getDBconnection();
        $stmt = $conn->prepare("select idusers from users where idusers = ?");
        $id = $this->id;
        $stmt->bind_param("i",$id);
        $res = $stmt->get_result();
        $val=$res->fetch_assoc();
        if ($val['idusers'] =="null" ){
            $this->exists = false;
        }else{
            $this->exists = true;
        }
        $stmt->close();
        $conn->close();
    }


    function getAvatarUrl($isSystemRoot = false):string{
        $rt = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists("$rt/upload/avatars/".$this->id.".png")){$rel = $this->id.".png";
        }elseif (file_exists("$rt/upload/avatars/".$this->id.".jpeg")){$rel = $this->id.".jpeg";
        }elseif (file_exists("$rt/upload/avatars/".$this->id.".gif")){$rel = $this->id.".gif";
        }else{$rel = "resources/no_avatar.png";}
        
        if ($isSystemRoot){
            return $rt."/".$rel;
        }else{
            return "/$rel";
        }
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
    function getUsername(){
        if (isset($this->username)){
            return $this->username;
        }else{
            $conn = getDBconnection();
            $stmt=$conn->prepare("select username from users where idusers=?");
            $stmt->bind_param("i",$this->id);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc()['username'];
            $stmt->close();
            $conn->close();
            $this->username = $res;
            return $res;
        }
    }
    function getAssocData():array{
        echo "bebra";
        echo $this->id;
        return Database::select("users","idusers",$this->id);
    }



    function register(){

        if (!($this->isExists())){
            $conn=getDBconnection();
            $stmt = $conn->prepare("insert into users (username,password,register_date,email,phone_unmber) values(?,?,?,?,?)");
            $time=time();
            $stmt->bind_param("ssiss",
             $this->username,
             $this->password,
             $time,
             $this->email,
             $this->phone
            );
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }else{
            return false;
        }
    }




    function updatePassword($pass_md5){
        Database::updateField("users","last_login_date","idusers",$this->id,$pass_md5);
    }

    function updateAvatar($newAvatar){
        $current = $this->getAvatarUrl();
        $ext = end(explode('.',$current));
        
    }

    function updateLastLoginDate($datetime = -1){
        if ($datetime == -1){$datetime=time();} // if datetime not set, get current time
        Database::updateField("users","last_login_date","idusers",$this->id,$datetime);
    }

    function updateLocation($location){
        Database::updateField("users","location","idusers",$this->id,$location);
    }

    function updateMood($mood){
        Database::updateField("users","mood","idusers",$this->id,$mood);
    }

    function updateemail($email){
        Database::updateField("users","email","idusers",$this->id,$email);
    }

    function updatePhone($phone){
        Database::updateField("users","phone_number","idusers",$this->id,$phone);
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

?>

