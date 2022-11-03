<?php

raiseHttpError(228);

function raiseHttpError($code){
    http_response_code($code);
    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    include("$ROOT/"."$code".".php");
    
}
