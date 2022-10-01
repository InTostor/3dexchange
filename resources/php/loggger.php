<?php
/**
 * Class Logger
 * @param string $type type of logger. can be *file* or *echo*
 * 
 * @method print($string $string) prints the string
 * 
 */
class Logger {
    public $type;
    private $file;
    private $database;
    private $table;
    function __construct($type) {
        $this->type = $type;
    }

    
    function setLogFile($filename){
        $this->file = $filename;
    }

    private function printToFile($text){
        $logfile = fopen($this->filename, "a");
        $timestamp = date(DATE_W3C ,time());
        $remoteAddr = $_SERVER['REMOTE_HOST'].":".$_SERVER['REMOTE_PORT'];
        $text = $timestamp."|".$remoteAddr."|".$text."\n" ;
        fwrite($logfile, $text);
    }
    private function printToPage($text){
        echo $text;
    }
    private function printToDatabase($text){

    }

    /**
     * method print
     * @param string $string. String you want to log
     * 
     */
    function print(string $text){
        if ($this->type == "echo"){
            $this->printToPage($text);
        }elseif ($this->type == "file"){
            $this->printToFile($text);
        }elseif ($this->type == "mysql"){
            $this->printToDatabase($text);
        }
    }



}




?>