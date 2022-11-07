<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/resources/php/classes/User.php";
session_start();
if (isset($_SESSION['ClassUser'])){
$usr = $_SESSION['ClassUser'];
}else{
    $usr = new User();
}
$canMakePart = $usr->checkPermission('part.create');

?>

<header>
    <div class="header_inner">
        <div class="header_upper">
            <div class="logo" id="logo">
                <a href="/" class="logo" id="logo">
                <img class="img_logo" src="/resources/images/logo.alpha.png">
                3DExchange</a>
            </div>
            <nav class="header_nav">
                <?php if($canMakePart){echo'<a class="navlink" id="addPart" href="item?add">+</a>';} ?>

                <a class="navlink" id="accLink" href="/account">акк</a>
            </nav>
        </div>
        <div class="header_bottom">
            <form action="/search" method="get" class="search">
                <input name="q" class="search_field" type="search" placeholder="производитель/id/тип/название/предназначение">
                <input name="submit" class="search_submit" type="button" type="submit" onclick="notavailable()" value="/искать/">
                <!-- add this type="submit" -->
            </form>
        </div>
    </div>
</header>