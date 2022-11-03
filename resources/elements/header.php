<?php


?>

<header>
    <div class="header_inner">
        <div class="header_upper">
            <a href="/" class="logo">3DExchange</a>
            <nav class="header_nav">
                <a class="navlink" href="item?add">+</a>

                <a class="navlink" href="/account">акк</a>
            </nav>
        </div>
        <div class="header_bottom">
            <form action="/search" method="get" class="search">
                <input name="q" class="search_field" type="search" placeholder="производитель/id/тип/название/предназначение">
                <input name="submit" class="search_submit" type="button" type="submit" onclick="notavailable()"   value="/искать/">
                <!-- add this type="submit" -->
            </form>
        </div>
    </div>
</header>

