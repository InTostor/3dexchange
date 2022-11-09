<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/Database.php");
require_once("$ROOT/resources/php/classes/Part.php");
require_once("$ROOT/resources/php/classes/settings.php");
require_once("$ROOT/resources/php/classes/FileBrowser.php");
include_once("$ROOT/settings/settings.php");

Class Realization{

    public $id;
    public $is_realization_of;
    public $name;
    public $author;
    public $rating;
    public $make_date;
    public $edit_date;
    public $description;

    function constructWithId($rid){
        $this->id=$rid;
    }

    function isExists(){
        $res = implode('',Database::executeStmt('SELECT EXISTS(SELECT * FROM realizations where idrealizations=?)',"s",[$this->id])[0]);
        if ($res==0){
            return false;
        }else{
            return true;
        }
    }

    function getPartId(){
        if (isset($this->is_realization_of)){
            return $this->is_realization_of;
        }else{
            return  Database::selectField('realizations','is_realization_of','idrealizations',$this->id);
        }
    }
    function getName(){
        if (isset($this->name)){
            return $this->name;
        }else{
            return  Database::selectField('realizations','name','idrealizations',$this->id);
        }
    }
    function geAuthorId(){
        if (isset($this->author)){
            return $this->author;
        }else{
            return  Database::selectField('realizations','author','idrealizations',$this->id);
        }
    }
    function getRating(){
        if (isset($this->name)){
            return $this->name;
        }else{
            return  Database::selectField('realizations','name','idrealizations',$this->id);
        }
    }
    function getMakeDate(){
        if (isset($this->make_date)){
            return $this->make_date;
        }else{
            return  Database::selectField('realizations','make_date','idrealizations',$this->id);
        }
    }
    function getEditDate(){
        if (isset($this->edit_date)){
            return $this->edit_date;
        }else{
            return  Database::selectField('realizations','edit_date','idrealizations',$this->id);
        }
    }
    function getDescription(){
        if (isset($this->description)){
            return $this->description;
        }else{
            return  Database::selectField('realizations','description','idrealizations',$this->id);
        }
    }

    function getFolder($isSystemRoot = false){
        $REALIZATIONS_STORAGE=config::get('realizations_storage');
        if ($isSystemRoot==false){
            
            return "/$REALIZATIONS_STORAGE/$this->is_realization_of/$this->id";
        }else{
                $rt = $_SERVER['DOCUMENT_ROOT'];
            return "$rt/$REALIZATIONS_STORAGE/$this->is_realization_of/$this->id";
            }
    }

    function geteditUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        return "/realization?edit&pid=$this->is_realization_of&rid=$this->id";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
            return "$r/realization?edit&pid=$this->is_realization_of&rid=$this->id";
        }
    }

    function getDocumentBrowser(){
        $P = new Part();
        $P->id= $this->is_realization_of;
        $returnUrl = $P->getViewUrl();
        FileBrowser::drawFileDownloader($this->getFilesList(),$this->getFolder(),$returnUrl);
    }

    function getFilesList(){
        return array_slice(scandir($this->getFolder(true)),2);
    }
    function deleteFile($filename){
        return unlink($this->getFolder(true)."/$filename");
    }

    function increaseRating(int $val=1){
        Database::executeStmt('update realizations set rating=rating+? where idrealizations = ?',"is",[$val,$this->id]);
    }
    function decreaseRating(int $val=1){
        Database::executeStmt('update realizations set rating=rating-? where idrealizations = ?',"is",[$val,$this->id]);
    }

    function updateName($name){
        Database::updateField("realizations","name","idrealizations",$this->id,$name);
    }
    function updateAuthor($author){
        Database::updateField("realizations","author","idrealizations",$this->id,$author);
    }
    function updateEditDate($datetime = -1){
        if ($datetime == -1){$datetime=time();} // if datetime not set, get current time
        Database::updateField("realizations","edit_date","idrealizations",$this->id,$datetime);
        $this->edit_date = $datetime;
    }
    function updateDescription($description){
        Database::updateField("realizations","description","idrealizations",$this->id,$description);
    }
    function updateImage($image){
        $REALIZATIONS_STORAGE=config::get('realizations_storage');
        $rt = $_SERVER['DOCUMENT_ROOT'];
        $newFile = "$rt/$REALIZATIONS_STORAGE/$this->is_realization_of/$this->id.png";
        File::moveAndRenameFile($image,$newFile);
    }

    function getImageUrl($isSystemRoot = false){
        return self::getImageUrlWithIds($this->is_realization_of,$this->id,$isSystemRoot);
    }


    function register(){
        if (!isset($this->id) and isset($this->is_realization_of)){          
            $this-> id = Database::executeStmt(
                "insert into realizations (`is_realization_of`,`name`,`author`,`make_date`,`description`) VALUES (?,?,?,?,?);",
                "sssss",
                [
                     $this->is_realization_of,
                     $this->name,
                     $this->author,
                     $this->make_date,
                     $this->description,
                ]
            );
            File::mkdir($this->getFolder(true));
        }else{
            return false;
        }
    }


    static function getImageUrlWithIds($pid,$rid,$isSystemRoot = false){
        $rt = $_SERVER['DOCUMENT_ROOT'];
        $REALIZATIONS_STORAGE=config::get('realizations_storage');
        $url = "$REALIZATIONS_STORAGE/$pid/$rid.png";
        if ($isSystemRoot){
            return "$rt/$url";
        }else{
            return "/$url";
        }
    }

    static function getUrlWithIds($pid,$rid){
        $url = "/item?view&id=$pid#$rid";
        return "$url";        
    }


}

