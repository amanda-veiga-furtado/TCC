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

    <style>
        html,
        body,
        .carousel,
        .carousel-caption,
        .carousel-caption h5,
        .carousel-caption p,
        .carousel-caption a {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        /* .carousel-control-prev {
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #a587ca;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100px;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
            .carousel-control-prev:hover {
            background-color: #8c6db6;
        } */
        .carousel-item {
            height: 100vh;
            background-size: cover;
            background-position: center;
        }

        .carousel-caption {
            bottom: 20%;
            text-align: center;
            z-index: 1000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        .carousel-caption a {
            pointer-events: auto;
        }

        .carousel-caption h5 {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .carousel-caption p {
            font-size: 1.2rem;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
        <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($selectedImages); $i++): ?>
                <li data-target="#carouselExampleIndicators"
                    data-slide-to="<?= $i ?>"
                    class="<?= $i === 0 ? 'active' : '' ?>"></li>
            <?php endfor; ?>
        </ol>

        <div class="carousel-inner">
            <?php foreach ($selectedImages as $index => $img): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"
                    style="background-image: url('<?= $img ?>');">
                    <div class="carousel-caption d-block">
                        <?php if ($index === 0): ?>
                            <h5>Explore Receitas</h5>
                            <p>Descubra uma variedade de receitas deliciosas.</p>
                            <a class="btn btn-primary" href="/TCC/src/receita/listagem_receitas.php">Ver Receitas</a>
                        <?php elseif ($index === 1): ?>
                            <h5>Crie Sua Receita</h5>
                            <p>Compartilhe suas próprias receitas.</p>
                            <a class="btn btn-primary" href="/TCC/src/receita/cadastrar_receita.php">Cadastrar</a>
                        <?php elseif ($index === 2): ?>
                            <h5>Busca por Ingredientes</h5>
                            <p>Receitas com o que você tem em casa.</p>
                            <a class="btn btn-primary" href="/TCC/src/receita/busca_ingrediente/busca_ingrediente.php">Buscar</a>
                        <?php elseif ($index === 3): ?>
                            <h5>Sugestões</h5>
                            <p>Receitas pensadas para você.</p>
                            <a class="btn btn-primary" href="/TCC/src/receita/sugestao.php">Ver</a>
                        <?php else: ?>
                            <h5>Faça Login</h5>
                            <p>Gerencie suas receitas.</p>
                            <a class="btn btn-primary" href="/TCC/src/usuario/login.php">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

</body>

</html>