<?php

Class Errors{


    static function raiseHttpError($code){
        http_response_code($code);
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
        include("$ROOT/"."$code".".php");
    }
    static function raiseCustomError($error_name){
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
        $mode="custom";
        $code=418;
        http_response_code($code);
        include("$ROOT/resources/static/cError.php");
    }

}

?>