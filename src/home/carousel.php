<?php
$imageDir = '../css/img/carousel/';
$images = glob($imageDir . '*.{jpg,png,jpeg,gif,JPG,PNG,JPEG,GIF}', GLOB_BRACE);
shuffle($images);
$selectedImages = array_slice($images, 0, 5);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap SOMENTE aqui -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS externo -->
    <link rel="stylesheet" href="../css/home_frontend.css">
</head>

<body>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="4000"
        aria-label="Carrossel principal do site">

        <ol class="carousel-indicators">
            <?php foreach ($selectedImages as $i => $img): ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"
                    class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></li>
            <?php endforeach; ?>
        </ol>

        <div class="carousel-inner">
            <?php foreach ($selectedImages as $index => $img): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"
                    style="background-image: url('<?= $img ?>');">

                    <div class="carousel-caption text-center">
                        <?php
                        $slides = [
                            ['Explore Receitas', 'Descubra uma variedade de receitas deliciosas.', '/TCC/src/receita/listagem_receitas.php', 'Ver Receitas'],
                            ['Crie Sua Receita', 'Compartilhe suas próprias receitas.', '/TCC/src/receita/cadastrar_receita.php', 'Cadastrar'],
                            ['Busca por Ingredientes', 'Receitas com o que você tem em casa.', '/TCC/src/receita/busca_ingrediente/busca_ingrediente.php', 'Buscar'],
                            ['Sugestões', 'Receitas pensadas para você.', '/TCC/src/receita/sugestao.php', 'Ver'],
                            ['Faça Login', 'Gerencie suas receitas.', '/TCC/src/usuario/login.php', 'Login'],
                        ];
                        ?>

                        <h5><?= $slides[$index][0] ?></h5>
                        <p><?= $slides[$index][1] ?></p>
                        <a class="btn-ver-receitas" href="<?= $slides[$index][2] ?>">
                            <?= $slides[$index][3] ?>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"
            aria-label="Slide anterior">
            <span class="carousel-control-prev-icon"></span>
        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"
            aria-label="Próximo slide">
            <span class="carousel-control-next-icon"></span>
        </a>

    </div>

</body>

</html>