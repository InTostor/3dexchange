я тебя, шайтана, манал. сыбись отсюда хацкер мамкин<br>
<?php

$url = ShowMeme();




function showMeme($r = 0){
    $m=2;
    $sel=rand(1,$m);
    if (isset($_REQUEST['n'])){$sel=$_REQUEST['n'];}
    if ($sel==1) {header('refresh:5;url="https://www.youtube.com/watch?v=dQw4w9WgXcQ"');}
    if ($sel==2) {echo'<iframe width="560" height="315" src="https://www.youtube.com/embed/ZdGNUJBPpO8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';}
    if ($sel==3) {}
    if ($sel==4) {}
    if ($sel==5) {}
    if ($sel==6) {}
    if ($sel==7) {}
    if ($sel==8) {}
    if ($sel==9) {}
    if ($sel==10){}
    return array($sel,$m);
}

?>

