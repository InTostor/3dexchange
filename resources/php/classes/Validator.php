<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once ("$ROOT/resources/php/classes/File.php");
class Validator{

    static function removeHazardousHtmlTags($str){
        $regex = '/<\s*?script.*?>|<\s*?iframe.*?>|<\s*?\/script.*?>|<\s*?\/iframe.*?>/m';
        $tmp = preg_replace($regex, '', $str);
        return $tmp;
    }
    static function isIp4Address($ipv4){
        
    }
    static function isIp6Address($ipv6){

    }

    static function removePhpTags($str){
        $regex = '/<\?php|\?>|<\?.*?>/m';
        $tmp = preg_replace($regex,'',$str);
        return $tmp;
    }

    static function removeHazardousTags($input){
        return strip_tags($input, 
        [
            'h1','h2','h3','h4','h5','h6','i','s','p','a','br','img','xmp',
            'table','tr','td','tr','pre','strong','strike','span','u','ul','small','time','code','samp','q'
        ]

    );
    }


    static function sanitizeUserInput($str){
        // $tmp = Validator::removeHazardousHtmlTags($str);
        // $tmp = Validator::removePhpTags($tmp);
        $tmp = self::removeHazardousTags($str);
        return $tmp;
    }

    static function isImage($file){
        echo File::getType($file);
        return explode("/",File::getType($file))[0]=="image";
    }

    static function formatToHtml($input){
        return preg_replace('/\n/m', '<br>', $input);
    }

}


?>

