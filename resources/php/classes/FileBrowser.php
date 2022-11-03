<?php

Class FileBrowser{

static function drawFileDownloader($filesList,$folder,$return){
    echo "<a href=$return>вернуться</a>";
    echo '<h1>Файлы</h1>';
    if (sizeof($filesList)==0){
        echo 'директория пуста';
    }
    self::drawStyle();
    foreach ($filesList as $id=>$file){
        $ext = pathinfo($file)['extension'];
        $exts = array("gif","png","webp","jpg","jpeg");
        $url = $folder."/".$file;
        echo "<form class='file' action='' method='post'>";
        if (in_array($ext,$exts)){
            echo "<img class='imgF' height=50px src= $url >";
        }else{
            echo '<div style="width:50px"></div>';
        }
        echo "
        
        <button class='download'><a href='$url'download=$url target='_blank'>скачать</a></button><h2>".
        $file.
        "</h2></form>";
    }
}

private static function drawStyle(){
    echo '
    <style>

    .download{
        height:50px;

    }

    .file{
        min-width:40%;
        margin:5px;
        height:50px;
        padding:2px;
        display:flex;
        flex-direction:row;
        text-align: center;
        box-shadow:0 0 30px 1px rgba(0, 0, 0, 0.479);
        border-radius: 10px;
    }
    .imgF{
        margin:0px;

    }
    .download{
        position:relative;
    </style>
    ';
}




}
?>