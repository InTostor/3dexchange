<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/Database.php");
require_once("$ROOT/resources/php/classes/settings.php");
include_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/classes/FileBrowser.php");

Class Part{

    public $id;
    public $exists;

    public $first_author;
    public $original_manufacturer;
    public $original_name;
    public $original_cost;
    public $original_material;
    public $original_made_for;
    public $fully_compatible_with;
    public $partly_compatible_with;
    public $tags;
    public $description;

    public function __serialize(): array {
        return [
            'first_author' => $this->first_author,
            'original_manufacturer' => $this->original_manufacturer,
            'original_name' => $this->original_name,
            'original_cost' => $this->original_cost,
            'original_material' => $this->original_material,
            'original_made_for' => $this->original_made_for,
            'fully_compatible_with' => $this->fully_compatible_with,
            'partly_compatible_with' => $this->partly_compatible_with,
            'tags' => $this->tags,
            'description' => $this->description
        ];
    }

    public function __unserialize(array $data): void {
        $this->first_author = $data['first_author'];
        $this->original_manufacturer = $data['original_manufacturer'];
        $this->original_name = $data['original_name'];
        $this->original_cost = $data['original_cost'];
        $this->original_material = $data['original_material'];
        $this->original_made_for = $data['original_made_for'];
        $this->fully_compatible_with = $data['fully_compatible_with'];
        $this->partly_compatible_with = $data['partly_compatible_with'];
        $this->tags = $data['tags'];
        $this->description = $data['description'];
    }

    function constructWithId(int $id){
        $this->id = $id;
        // $this->exists = $this->isExists();
    }

    function getViewUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        return "/item?view&id=$this->id";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
            return "$r/item?view&id=$this->id";
        }
    }
    
    function geteditUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
        return "/item?edit&id=$this->id";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
            return "$r/item?edit&id=$this->id";
        }
    }
    static function getAddUrl($isSystemRoot = false){
        if ($isSystemRoot==false){
            return "/item?add.php";
        }else{
            $r = $_SERVER['DOCUMENT_ROOT'];
            return "$r/item?add.php";
        }
    }

    function isExists(){
        $conn = getDBconnection();
        $stmt = $conn->prepare("select idparts from parts where idparts=?");
        echo "f<br><br>$this->id<br><br>f";
        $stmt->bind_param("s",$this->id);
        $stmt->execute();
        if ($stmt->get_result()->fetch_assoc()['idparts']=="null" ){
            $this->exists = false;
        }else{
            $this->exists = true;
        }
        $stmt->close();
        $conn->close();
    }

    function getImagesFolder($isSystemRoot = false){
        $PARTS_STORAGE = config::get('parts_storage');
        if ($isSystemRoot==false){
            
            return "/$PARTS_STORAGE/$this->id/images";
            }else{
                $rt = $_SERVER['DOCUMENT_ROOT'];
            return "$rt/$PARTS_STORAGE/$this->id/images";
            }
    }
    function getImagesList(){
       return array_slice(scandir($this->getImagesFolder(true)),2);
    }
    function getDocumentsList(){
        return array_slice(scandir($this->getDocumentsFolder(true)),2);
    }

    function addImage($imgFile){
        File::moveFile($imgFile,$this->getImagesFolder()."/".pathinfo($imgFile)['basename']);
    }

    function deleteImage($filename){
        return unlink($this->getImagesFolder(true)."/$filename");
    }
    function deleteDocument($filename){
        return unlink($this->getDocumentsFolder(true)."/$filename");
    }

    
    function getDocumentsFolder($isSystemRoot = false){
        $PARTS_STORAGE=config::get('parts_storage');
        if ($isSystemRoot==false){
            
            return "/$PARTS_STORAGE/$this->id/images";
        }else{
                $rt = $_SERVER['DOCUMENT_ROOT'];
            return "$rt/$PARTS_STORAGE/$this->id/documents";
            }
    }
    
    function getFirstAuthor(){
        if (isset($this->first_author)){
            return $this->first_author;
        }else{
        return  Database::selectField('parts','first_author','idparts',$this->id);
        }
    }
    function getOriginalManufacturer(){
        if (isset($this->original_manufacturer)){
            return $this->original_manufacturer;
        }else{
        return  Database::selectField('parts','original_manufacturer','idparts',$this->id);
        }
    }
    function getOriginalName(){
        if (isset($this->original_name)){
            return $this->original_name;
        }else{
        return  Database::selectField('parts','original_name','idparts',$this->id);
        }
    }
    function getOriginalCost(){
        if (isset($this->original_cost)){
            return $this->original_cost;
        }else{
        return  Database::selectField('parts','original_cost','idparts',$this->id);
        }
    }
    function getOriginalMaterial(){
        if (isset($this->original_material)){
            return $this->original_material;
        }else{
        return  Database::selectField('parts','original_material','idparts',$this->id);
        }
    }
    function getOriginalmadeFor(){
        if (isset($this->original_made_for)){
            return $this->original_made_for;
        }else{
        return  Database::selectField('parts','original_made_for','idparts',$this->id);
        }
    }
    function getFullyCompatibleWith(){
        if (isset($this->fully_compatible_with)){
            return $this->fully_compatible_with;
        }else{
        return  Database::selectField('parts','fully_compatible_with','idparts',$this->id);
        }
    }
    function getPartlyCompatibleWith(){
        if (isset($this->partly_compatible_with)){
            return $this->partly_compatible_with;
        }else{
        return  Database::selectField('parts','partly_compatible_with','idparts',$this->id);
        }
    }
    function getTags(){
        if (isset($this->tags)){
            return $this->tags;
        }else{
        return  Database::selectField('parts','tags','idparts',$this->id);
        }
    }
    function getDescription(){
        if (isset($this->description)){
            return $this->description;
        }else{
        return  Database::selectField('parts','description','idparts',$this->id);
        }
    }
    function getCategory(){
        if (isset($this->category)){
            return $this->category;
        }else{
        return  Database::selectField('parts','category','idparts',$this->id);
        }
    }



    function getRealizations(){
        return Database::executeStmt(
            "select * from realizations where is_realization_of = ?",
            "i",
            [$this->id]
        );
    }


    function updateFirstAuthor($author){
        Database::updateField("parts","first_author","idparts",$this->id,$author);
        $this->first_author = $author;
    }

    function updateOriginalManufacturer($manufacturer){
        Database::updateField("parts","original_manufacturer","idparts",$this->id,$manufacturer);
        $this->original_manufacturer = $manufacturer;
    }

    function updateOriginalName($name){
        Database::updateField("parts","original_name","idparts",$this->id,$name);
        $this->original_name = $name;
    }

    function updateOriginalCost($cost){
        Database::updateField("parts","original_cost","idparts",$this->id,$cost);
        $this->original_cost = $cost;
    }

    function updateOriginalMaterial($material){
        Database::updateField("parts","original_material","idparts",$this->id,$material);
        $this->original_material = $material;
    }

    function updateOriginalmadeFor($originalMadeFor){
        Database::updateField("parts","original_made_for","idparts",$this->id,$originalMadeFor);
        $this->original_made_for = $originalMadeFor;
    }

    function updateFullyCompatibleWith($fullyCompatibleWith){
        Database::updateField("parts","fully_compatible_with","idparts",$this->id,$fullyCompatibleWith);
        $this->fully_compatible_with = $fullyCompatibleWith;
    }

    function updatePartlyCompatibleWith($partlyCompatibleWith){
        Database::updateField("parts","partly_compatible_with","idparts",$this->id,$partlyCompatibleWith);
        $this->partly_compatible_with = $partlyCompatibleWith;
    }

    function updateTags($tags){
        Database::updateField("parts","tags","idparts",$this->id,$tags);
        $this->tags = $tags;
    }


    function register(){

        if (!isset($this->id)){
            
            $ROOT = $_SERVER['DOCUMENT_ROOT'];
            
            $this-> id = Database::executeStmt(
                "insert into parts (`first_author`, `original_manufacturer`, `original_name`, `original_cost`, `original_material`, `original_made_for`,`fully_compatible_with`,`partly_compatible_with`,`tags`) VALUES (?,?,?,?,?,?,?,?,?);",
                "sssssssss",
                [
                     $this->first_author,
                     $this->original_manufacturer,
                     $this->original_name,
                     $this->original_cost,
                     $this->original_material,
                     $this->original_made_for,
                     $this->fully_compatible_with,
                     $this->partly_compatible_with,
                     $this->tags
                ]
            );

            global $PARTS_STORAGE;
            $PARTS_STORAGE ="upload/parts";
            mkdir($ROOT."/".$PARTS_STORAGE."/".$this->id);
            mkdir($this->getImagesFolder(true));
            mkdir($this->getDocumentsFolder(true));

        }else{
            return false;
        }
    }

    static function getCategoriesList(){
        $cats = array(
            array('val'=>'none','desc'=>'-'),
            array('val'=>'large_appliances','desc'=>'крупная бытовая техника'),
            array('val'=>'small_appliances','desc'=>'малая бытоввая техника'),
            array('val'=>'light_vehicle','desc'=>'лёгкий транспорт'),
            array('val'=>'heavy_vehicle','desc'=>'тяжелый транспорт'),
            array('val'=>'wearable_electronics','desc'=>'носимая электроника'),
            array('val'=>'toys_rc','desc'=>'игрушки и Р/У модели'),
            array('val'=>'photo_equipment','desc'=>'фототехника'),
            array('val'=>'none','desc'=>'-'),
            array('val'=>'none','desc'=>'-'),
            array('val'=>'none','desc'=>'-'),
            array('val'=>'none','desc'=>'-'),
            array('val'=>'none','desc'=>'-'),
            );
        return $cats;
    }
    static function convertIdToName($id){
        return Database::executeStmt('select concat(original_manufacturer," / ",original_name) from parts where idparts = ?',"s",[$id])[0]['concat(original_manufacturer," / ",original_name)'];
    }


}

