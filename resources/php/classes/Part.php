<?php
Class Part{

    public $id;
    public $name;
    public $exists;


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

    function isExists(){
        $conn = getDBconnection();
        $stmt = $conn->prepare("select idparts from parts where idparts=?");
        $stmt->bind_param("i",$this->id);

        if ($stmt->get_result()->fetch_assoc()['idparts']=="null" ){
            $this->exists = false;
        }else{
            $this->exists = true;
        }
        $stmt->close;
        $conn->close();
    }
    

    function make(){

        if (!($this->isExists())){

        }else{
            return false;
        }

    }



}