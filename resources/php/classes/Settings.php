<?php
$ROOT=$_SERVER['DOCUMENT_ROOT'];
$Sini = parse_ini_file("$ROOT/settings/settings.ini");
global $Sini;
Class config{
    static function get($r){
        global $Sini;
        return $Sini[$r];
    }
}