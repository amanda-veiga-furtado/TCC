<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();

include_once 'conexao.php';
include_once 'css/frontend.php';
include_once 'menu.php';
include_once 'functions/fracoes_functions.php';
?>
<script src="functions/script_defer.js" defer></script>