<?php
class Validator{


    static function removeHazardousHtmlTags($str){
        $regex = '/<\s*?script.*?>|<\s*?iframe.*?>|<\s*?\/script.*?>|<\s*?\/iframe.*?>/m';
        $tmp = preg_replace($regex, '', $str);
        return $tmp;
    }
    function isIp4Address($ipv4){

    }
    function isIp6Address($ipv6){

    }

    static function removePhpTags($str){
        $regex = '/<\?php|\?>|<\?.*?>/m';
        $tmp = preg_replace($regex,'',$str);
        return $tmp;
    }


    static function sanitizeUserInput($str){
        $tmp = Validator::removeHazardousHtmlTags($str);
        $tmp = Validator::removePhpTags($tmp);
        return $tmp;
    }

}


?>

