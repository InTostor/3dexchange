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
<div class="page">
<?php 
$m=7;
$sel=rand(1,$m);

if ($sel==1) {echo '<video autoplay class="meme" loop="loop"  poster="https://coub-attachments.akamaized.net/coub_storage/coub/simple/cw_timeline_pic/be9981f51bc/557d8e6e2f4d5e204428e/med_1599669095_image.jpg" src="/resources/error_memes/Tom.mp4"></video>';}
if ($sel==2) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/stickbug.gif"> ' ;}
if ($sel==3) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/rick.gif"> ' ;}
if ($sel==4) {echo '<video autoplay muted class="meme" loop="loop"   src="/resources/error_memes/saul.mp4"></video>';}
if ($sel==5) {echo '<img style="margin-top:-20vh"height="40%" width="100%" src="/resources/error_memes/polish-cow.gif"> ' ;}
if ($sel==6) {echo '<img style="margin-top:-30vh"height="40%" width="100%" src="https://c.tenor.com/-GltUnlpQtkAAAAd/biden-fails.gif">' ;}
if ($sel==7) {echo '<video autoplay muted class="meme" loop="loop"   src="/resources/error_memes/pc.mp4"></video>';}

?>

<div class="blurer">

    <div class=return>
    <h1 >что-то поломалось. <a href="/"> Вернуться? </a> </h1>
    <h5><?=decbin($sel)."b"?>/<?=decbin($m)."b"?></h5>
    </div>

</div>



</div>