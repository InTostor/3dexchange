<?php

$ROOT = $_SERVER['DOCUMENT_ROOT'];
require("$ROOT/resources/php/show_error.php");

if ($mode!="custom"){

$ru_desc = $error_descriptions[$code]['desc'];
$rfc_desc = $error_descriptions[$code]['rfc'];
}else{
    $ru_desc = $cError_descriptions[$error_name]['desc'];
    $rfc_desc = $cError_descriptions[$error_name]['rfc'];   
}

?>
<div class="page">
<?php
$ma = showMeme();
$sel=$ma[0];
$m=$ma[1];
?>




<div class="blurer">

    <div class=return>
    <h1 ><?=$ru_desc?>. <a href="/"> Вернуться? </a> </h1>
    <h4><?=$rfc_desc?></h4>
    <h5><?=decbin($sel)."b"?>/<?=decbin($m)."b"?></h5>
    </div>

</div>
</div>