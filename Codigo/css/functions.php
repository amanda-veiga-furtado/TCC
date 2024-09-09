<?php
    $images = range(1, 23); // Array com o nome das imagens
    $randomImage = $images[array_rand($images)]; // Seleciona uma imagem aleatória    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container_form {
            width: 100vw;
            height: 85.3vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body>   
</body>
</html>