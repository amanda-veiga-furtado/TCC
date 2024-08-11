<?php
    include_once '../menu.php'; 
    include_once '../conexao.php'; 

    $images = range(1, 13); // Array com o nome das imagens
    $randomImage = $images[array_rand($images)]; // Seleciona uma imagem aleatória
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Faça Sua Sugestão! Nos Ajude a Melhorar</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container_sugestao {
            width: 100vw;
            height: 85.3vh;
            background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <div class="container_sugestao">

    </div>
</body>
</html>
