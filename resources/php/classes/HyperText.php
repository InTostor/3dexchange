<?php

Class HyperText{

    static function moveUserToLoc($location,$delay=1){
        if ($delay==0){
            header("Location: $location");
        }else{
            header("Refresh: $delay; url=$location");
        }
    }
    static function moveUserToPrevLoc($delay=0){
        if (isset($_SERVER['HTTP_REFERER'])){
            self::moveUserToLoc($_SERVER['HTTP_REFERER'],$delay);
        }else{
            self::moveUserToLoc("/");
        }
    }


}


?>