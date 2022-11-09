<style>
    html, body {margin: 0; height: 100%; overflow: hidden}
.meme{
    margin:0;
    width:100%;
    position: absolute;
    top:0px;
}

.blurer{
    position: absolute;
    top:0px;
    width:100%;
    height:100vh;
    backdrop-filter: blur(5px) sepia(70%);
}

.page{
    display: flex;
    flex-direction: column;
}

.return{
    margin:5% auto auto 10%;
    padding:10px;
    border-radius: 10px;
    box-shadow:0 0 30px 1px rgba(0, 0, 0, 0.479);
    width:fit-content;
    backdrop-filter:hue-rotate(10deg) contrast(105%) brightness(105%);
}
</style>

<?php 

$error_descriptions=array(
    "400"=>array("desc"=>"Ваш запрос не корректен и поэтому не может быть обработан","rfc"=>"400 Bad Request"),
    "401"=>array("desc"=>"Доступно только для авторизованных пользователей","rfc"=>"401 Unathorized"),
    "404"=>array("desc"=>"не найдено","rfc"=>"404 Bad Request"),
    "429"=>array("desc"=>"увага, виявлена підозріла активність. ддос аттакер припиніть негайно","rfc"=>"429 Too Many Requests"),
);

$cError_descriptions=array(
    'default'=>array('desc'=>'что-то пошло не так, но что именно пока не известно','rfc'=>'default error хз что'),
    'logged'=>array('desc'=>'Доступно только для НЕзарегестрированных пользователей','rfc'=>'relogin loop'),
);




function showMeme($r = 0){
    $m=10;
    $sel=rand(1,$m);
    if (isset($_REQUEST['n'])){$sel=$_REQUEST['n'];}
    if ($sel==1) {echo '<video autoplay class="meme" loop="loop"  poster="https://coub-attachments.akamaized.net/coub_storage/coub/simple/cw_timeline_pic/be9981f51bc/557d8e6e2f4d5e204428e/med_1599669095_image.jpg" src="/resources/error_memes/Tom.mp4"></video>';}
    if ($sel==2) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/stickbug.gif"> ' ;}
    if ($sel==3) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/rick.gif"> ' ;}
    if ($sel==4) {echo '<video autoplay muted class="meme" loop="loop"   src="/resources/error_memes/saul.mp4"></video> <style>*{color:white;}</style>';}
    if ($sel==5) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/polish-cow.gif"> ' ;}
    if ($sel==6) {echo '<img style="margin-top:-30vh"height="40%" width="100%" src="https://c.tenor.com/-GltUnlpQtkAAAAd/biden-fails.gif">' ;}
    if ($sel==7) {echo '<video autoplay muted class="meme" loop="loop"   src="/resources/error_memes/pc.mp4"></video>';}
    if ($sel==8) {echo '<img style="margin:-30% 0 0 0 " height="100%" width="100%" src="/resources/error_memes/stalin.gif"> ' ;}
    if ($sel==9) {echo '<img style="margin:0 0 0 0 " height="100%" width="100%" src="/resources/error_memes/dallas.gif"> <style>*{color:white;}</style>' ;}
    if ($sel==10) {echo '<video style="margin:-30vh 0 0 0 ;filter:saturate(1.2)brightness(1.2)hue-rotate(20deg)" autoplay muted class="meme" loop="loop"  src="/resources/error_memes/goat.mp4"></video><style>.blurer{backdrop-filter:none;}*{color:white;} </style>' ;}
    return array($sel,$m);
}

?>



