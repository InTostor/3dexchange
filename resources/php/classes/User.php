<?php

require_once('Database.php');
require_once('File.php');
require_once $_SERVER['DOCUMENT_ROOT']."/settings/settings.php";



class User {

    public $username;
    public $id;
    public $access_level;
    public $last_login_date;
    public $exists;
    private $email;
    private $phone;
    public $location;
    public $description_md;
    public $mood;
    public $register_date;
    public $permissions;

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
            'location' => $this->location,
            'description_md' => $this->description_md,
            'mood' => $this->mood,
            'register_date' => $this->register_date
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
        $this->location = $data['location'];
        $this->description_md = $data['description_md'];
        $this->mood = $data['mood'];
        $this->register_date = $data['register_date'];

    }
// pack/unpack class for transfer

    function constructWithId(int $id){
        $this->id = $id;
        $this->username=$this->convertIdToUsername($id);
        // $this->exists = $this->isExists();
    }
    
    function constructWithUsername(string $username){
        $this->username = $username;
        $this->id=$this->convertUsernameToId($username);
        // $this->exists = $this->isExists();
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
            $conn = getDB();
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
            $this->id=$this->convertUsernameToId($this->username);
            // $this->exists = $this->isExists();
        }
        return $logged;
    }
    
// ! remember that user view is in /user and user editing in /account/actions.php

    function getViewUrl($isSystemRoot = false){
        return $this->getViewUrlWithId($this->id,$isSystemRoot);
    }
    static function getViewUrlWithId($id,$isSystemRoot = false){
        if ($isSystemRoot==false){
            return "/user?view&id=$id";
            }else{
                $rt = $_SERVER['DOCUMENT_ROOT'];
            return "$rt/user?view&id=$id";
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

    function getPermissions(){

        if (isset($this->id)){
            if (!isset($this->permissions)){
                $pStr =  Database::executeStmt(
                'SELECT permissions FROM 3dexchange.usperm_groups where `key` = (select access_level from users where idusers = ?)',
                "s",
                [$this->id]
                )[0]['permissions'];
                return explode(';',$pStr);
            }else{
                return $this->permissions;
            }
        }else{
            $pStr =  Database::executeStmt(
                'SELECT permissions FROM 3dexchange.usperm_groups where `key` = ?',
                "s",
                [3]
                )[0]['permissions'];
                return explode(';',$pStr);
        }

    }

    function checkPermission(string $permission){
        $perms = $this->getPermissions();
        foreach ($perms as $perm){
            if (preg_match_all("/$perm/m", $permission)>0 or preg_match_all("/$permission/m","$perm")>0){
                return true;
            }
        }
        return false;
        
    }

    function checkPassword($pass_md5){
        return Database::selectField('users','password','idusers',$this->id) == $pass_md5 ;
    }


    function isExists(){
        $conn = getDB();
        $stmt = $conn->prepare("select idusers from users where idusers = ?");
        $stmt->bind_param("i",$this->id);
        $stmt->execute();
        $res = $stmt->get_result();
        $val=$res->fetch_assoc();
        if ($val['idusers'] =="null" ){
            $this->exists = false;
        }else{
            $this->exists = true;
        }
        $stmt->close();
        $conn->close();
        return $this->exists;
    }


    function getAvatarUrl($isSystemRoot = false):string{
        $rt = $_SERVER['DOCUMENT_ROOT'];
        global $USER_AVATAR_STORAGE;
        if (file_exists("$rt/upload/avatars/".$this->id.".png")){$rel = $this->id.".png";
        }elseif (file_exists("$rt/upload/avatars/".$this->id.".jpeg")){$rel = $this->id.".jpeg";
        }elseif (file_exists("$rt/upload/avatars/".$this->id.".gif")){$rel = $this->id.".gif";
        }else{$rel = "resources/no_avatar.png";}

        if ($isSystemRoot){
            return $rt."/".$USER_AVATAR_STORAGE."/".$rel;
        }else{
            return "/".$USER_AVATAR_STORAGE."/$rel";
        }
    }


    function getEmail(){
        if (isset($this->email)){
            return $this->email;
        }else{
            $conn = getDB();
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
            $conn = getDB();
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
            $conn = getDB();
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
        return Database::select("users","idusers",$this->id);
    }

    function getDescription(){
        if (isset($this->description_md)){
            return $this->description_md;
        }else{
        $r =  Database::selectField('users','description_md','idusers',$this->id);
        }
        return $r;
    }
    function getLocation(){
        if (isset($this->location)){
            return $this->location;
        }else{
        $r =  Database::selectField('users','location','idusers',$this->id);
        }
        return $r;
    }
    function getMood(){
        if (isset($this->mood)){
            return $this->mood;
        }else{
        $r =  Database::selectField('users','mood','idusers',$this->id);
        }
        return $r;
    }
    function getRegisterDate(){
        if (isset($this->register_date)){
            return $this->register_date;
        }else{
        return  Database::selectField('users','register_date','idusers',$this->id);
        }
    }


    function register(){

        if (!($this->isExists())){
            $conn=getDB();
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
        Database::updateField("users","password","idusers",$this->id,$pass_md5);
    }

    function updateAvatar($newAvatar){
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
        $current = $this->getAvatarUrl(true);
        $newFile = File::convertImageToPNG($newAvatar);
        if (pathinfo($current)['filename']!="no_avatar"){
        unlink($current);
        }
        global $USER_AVATAR_STORAGE;
        $save = fopen("$ROOT/$USER_AVATAR_STORAGE/$this->id".".png","w");
        echo var_dump($newFile);
        move_uploaded_file($newFile, "$ROOT/$USER_AVATAR_STORAGE/$this->id".".png");


    }



    function updateLastLoginDate($datetime = -1){
        if ($datetime == -1){$datetime=time();} // if datetime not set, get current time
        Database::updateField("users","last_login_date","idusers",$this->id,$datetime);
        $this->last_login_date = $datetime;
    }

    function updateLocation($location){
        Database::updateField("users","location","idusers",$this->id,$location);
        $this->location = $location;
    }

    function updateMood($mood){
        Database::updateField("users","mood","idusers",$this->id,$mood);
        $this->mood=$mood;
    }

    function updateEmail($email){
        Database::updateField("users","email","idusers",$this->id,$email);
        $this->email=$email;
    }

    function updatePhone($phone){
        Database::updateField("users","phone_number","idusers",$this->id,$phone);
        $this->phone=$phone;
    }


    static function convertUsernameToId($username){
        $conn = getDB();
    
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
    
    
    static function convertIdToUsername(int $id){
        $conn = getDB();
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
    static function isLogged(){
        $is_logged = false;
        if (isset($_COOKIE['logged_as']) and isset($_COOKIE['logged_with'])){
            $is_logged = $_COOKIE['logged_as']!="null" and $_COOKIE['logged_with']!="null";
            return $is_logged and self::isLegitLogin();
        }else{
            return false;
        }
        
    }
    static function isLegitLogin(){
        $username_given = $_COOKIE["logged_as"];
        $password_given = $_COOKIE["logged_with"];
        return self::checkCredentials($username_given,$password_given);
    }
    static function getLoggedAs(){
        if (isset($_COOKIE['logged_as'])){
        return $_COOKIE['logged_as'];
        }else{
            return "null";
        }
    }
    static function checkCredentials($username,$pass,$passCode="md5"){
        if ($passCode=="raw"){
            $pass = md5($pass);
        }
        $row = Database::executeStmt('SELECT idusers FROM users where username = ? and password = ?',"ss",[$username, $pass]);
        if ($row!=null){
            $is_legit = true;
        }else{
            $is_legit = false;
        }
        return $is_legit;
    }
    function isAuthorOf($item,$id){
        if ($item == "part"){
            $query = 'SELECT EXISTS(SELECT idparts FROM parts where author = ? and idparts = ?)';
            $sel = 'EXISTS(SELECT idparts FROM parts where author = ? and idparts = ?)';
            $proceed = true;
        }elseif($item=="realization"){
            $query = 'SELECT EXISTS(SELECT idrealizations FROM realizations where author = ? and idrealizations = ?)';
            $sel = 'EXISTS(SELECT idrealizations FROM realizations where author = ? and idrealizations = ?)';
            $proceed = true;
        }
        if ($proceed and Database::executeStmt($query,"ss",[$this->id,$id])[0][$sel]==1){
            return true;
        }else{
            return false;
        }
    }
}
?>