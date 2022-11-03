<?php

class File{



    static function convertImageToPNG($image){

        if (exif_imagetype($image) ==  "IMAGETYPE_GIF") {
            return rename($image,pathinfo($image)['name'].".png");
        }elseif(exif_imagetype($image) == "IMAGETYPE_PNG"){
            echo "bebra";
            return $image;
        }elseif(exif_imagetype($image) ==  "IMAGETYPE_JPEG"){
            return imagepng(imagecreatefromjpeg($image),pathinfo($image)['name'].".png");
        }elseif(exif_imagetype($image) ==  "IMAGETYPE_WEBP"){
            return imagepng(imagecreatefromwebp($image),pathinfo($image)['name'].".png");
        }
        return $image;
    }

    static function cleanTempShit($dir){
        foreach (scandir("$dir") as $file) {
            if (preg_match_all('/php.{4}./m',pathinfo($file)['basename'])){
                // echo pathinfo($file)['basename']."<br>";
                unlink($file);
            }
        }
    }

    static function moveFile($file,$destination){
        return rename($file,$destination.pathinfo($file)['basename']);
    }
    static function renameFile($file,$newBaseName){
        return rename($file,$newBaseName);
    }
    static function moveAndRenameFile($file,$newFile){
        $dir = pathinfo($newFile)['dirname'];
        if (!file_exists($dir)) {
            self::mkdir($dir);
        }
        return rename($file,$newFile);
    }

    static function getType($file){
        return mime_content_type($file);
    }

    static function packIntoTar(){
        //nothing yet
    }
    
    static function mkdir($path){
        echo var_dump(file_exists($path));
        if (!file_exists($path)) {
            echo "<br><br><br>$path<br><br>f<br>";
            mkdir($path,recursive:true);
        }
    }

    static function fileSize($filename){
        return filesize($filename);
    }


}
