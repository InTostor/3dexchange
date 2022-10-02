<?php

function deleteIfExists($file){
    if (file_exists($file)){
        unlink($file);
    }
}


?>