<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicia o buffer de saída
ob_start();

// Inclui arquivos essenciais do projeto
require_once 'conexao.php';
require_once 'css/frontend.php';
require_once 'menu.php';
require_once 'functions/fracoes_functions.php';
require_once 'functions/script_defer.php';