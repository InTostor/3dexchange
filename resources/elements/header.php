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
$isUserLogged = User::isLogged();

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
                <?php if($canMakePart){echo'<a class="navlink" id="addPart" href="item?add"><span class="material-icons addPart">post_add</span></a>';} ?>
                <a class="navlink" id="accLink" href="/account"><span class="material-icons account">account_circle</span></a>
                <?php if($isUserLogged){echo'<a class="navlink" id="addPart" href="/account/logout.php"><span class="material-icons addPart">logout</span></a>';} ?>
            </nav>
        </div>
        <div class="header_bottom">
            <form action="/search" method="get" class="search">
                <input name="q" class="search_field" type="search" required placeholder="производитель/id/тип/название/предназначение">
                <button name="submit" class="search_submit" type="submit" type="submit" value="/искать/">
                    <span class="material-icons account">search</span>
                </button>
                <!-- add this type="submit" -->
            </form>
        </div>
    </div>
</header>