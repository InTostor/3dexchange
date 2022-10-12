<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/settings/settings.php";
require_once "$ROOT/resources/php/common.php";

$secret_message = " за руку";

if (isLogged() and getLoggedAs()=="Hold4n"){
$secret_message = "INC30LAg0YfQu9C10L0=";
}
?>

<footer>
    <div class="footer_inner">
        <div class="contacts fcol">
            <h3>БД деталей и узлов для 3д печати</h3>
            <a class="flink" href="mailto:name@example.com">name@example.com</a>
            <a class="flink" href="https://github.com/InTostor">made with 🍏 by InTostor</a>
        </div>
        <div class="donate fcol">
            <h3>поддержать меня<span style="color:rgba(0,0,0,0.01)"><?=base64_decode($secret_message)?></span></h3>
            <h6> ETH: 0xe4d8e5994e0940cf5300f36ccd74d269812daca5</h6>
        </div>
        <div class="fnav">
            <a href="/documents/privacy.txt">Политика конфиденциальности</a>
            <a href="/documents/rules.txt">Правила</a>

        </div>
    </div>
</footer>