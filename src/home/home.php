<?php
session_start();
ob_start();

include_once '../css/frontend.php';
include_once '../menu.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>

<body>

    <!-- Carrossel isolado -->
    <iframe
        src="carousel.php"
        style="width:100%; height:86.6vh; border:none; display:block;"
        loading="lazy"
        aria-label="Carrossel de destaques">
    </iframe>

    <!-- resto da home -->
</body>

</html>