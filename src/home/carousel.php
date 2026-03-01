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
        /*  ================================
                RESET TIPOGRÁFICO
            ================================ */
        body,
        html {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /*  ==============================
                CARROSSEL
            ================================ */
        .carousel-item {
            height: 100vh;
            min-height: 420px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Overlay escuro */
        .carousel-item::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.0);
            z-index: 1;
        }

        /*  ==============================
             CAPTION
            ================================ */
        .carousel-caption {
            bottom: 22%;
            z-index: 2;
            animation: fadeUp 0.8s ease;
        }

        .carousel-caption h5 {
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 700;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, .8);
        }

        .carousel-caption p {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            max-width: 720px;
            margin: 0 auto 20px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, .7);
        }

        /*  ==============================
                BOTÃO
            ================================ */
        .btn-ver-receitas {
            background-color: #a587ca;
            color: #fff !important;
            border-radius: 10px;
            padding: 14px 28px;
            font-size: 1.1rem;
            font-weight: 600;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: min(90%, 360px);
            transition: all .3s ease;
            text-decoration: none !important;
        }

        .btn-ver-receitas:hover {
            background-color: #8c6db6;
            transform: translateY(-2px);
        }

        /*  ==============================
                CONTROLES
            ================================ */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: drop-shadow(0 0 6px rgba(0, 0, 0, .6));
        }

        /*  ==============================
                ANIMAÇÃO
            ================================ */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /*  ==============================
                MOBILE
            ================================ */
        @media (max-width: 768px) {
            .carousel-caption {
                bottom: 18%;
                padding: 0 15px;
            }
        }
    </style>
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