<?php
session_start();
ob_start();

include_once '../conexao.php';
include '../css/frontend.php';

// Get random images from carousel folder
$imageDir = '../css/img/carousel/';
$images = glob($imageDir . '*.{jpg,png,jpeg,gif,JPG,PNG,JPEG,GIF}', GLOB_BRACE);
shuffle($images);
$selectedImages = array_slice($images, 0, 5); // Get 5 unique random images
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            padding-top: 80px;
        }
        nav {
            margin: 0;
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .carousel {
            height: calc(100vh - 80px);
            margin-top: 0;
        }
        .carousel-item {
            height: calc(100vh - 80px);
            background-size: cover;
            background-position: center;
        }
        .carousel-caption {
            bottom: 20%;
            text-align: center;
            z-index: 1000;
        }
        .carousel-caption a {
            pointer-events: auto;
        }
        .carousel-caption h5 {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        .carousel-caption p {
            font-size: 1.2rem;
            color: white;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
        }
        .btn-primary {
            background-color: var(--vermelho-primario);
            border-color: var(--vermelho-primario);
        }
        .btn-primary:hover {
            background-color: var(--vermelho-secundario);
            border-color: var(--vermelho-secundario);
        }
    </style>
</head>

<body>
    <?php include_once '../menu.php'; ?>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
	  </ol>
	  <div class="carousel-inner">
	    <div class="carousel-item active" style="background-image: url('<?php echo $selectedImages[0]; ?>');">
	      <div class="carousel-caption d-block">
	        <h5>Explore Receitas</h5>
	        <p>Descubra uma variedade de receitas deliciosas.</p>
	        <a class="btn btn-primary" href="/TCC/src/receita/listagem_receitas.php">Ver Receitas</a>
	      </div>
	    </div>
	    <div class="carousel-item" style="background-image: url('<?php echo $selectedImages[1]; ?>');">
	      <div class="carousel-caption d-block">
	        <h5>Crie Sua Receita</h5>
	        <p>Compartilhe suas próprias receitas com a comunidade.</p>
	        <a class="btn btn-primary" href="/TCC/src/receita/cadastrar_receita.php">Cadastrar Receita</a>
	      </div>
	    </div>
	    <div class="carousel-item" style="background-image: url('<?php echo $selectedImages[2]; ?>');">
	      <div class="carousel-caption d-block">
	        <h5>Busca por Ingredientes</h5>
	        <p>Encontre receitas baseadas nos ingredientes que você tem.</p>
	        <a class="btn btn-primary" href="/TCC/src/receita/busca_ingrediente/busca_ingrediente.php">Buscar Receitas</a>
	      </div>
	    </div>
	    <div class="carousel-item" style="background-image: url('<?php echo $selectedImages[3]; ?>');">
	      <div class="carousel-caption d-block">
	        <h5>Sugestões Personalizadas</h5>
	        <p>Receba sugestões de receitas baseadas em suas preferências.</p>
	        <a class="btn btn-primary" href="/TCC/src/receita/sugestao.php">Ver Sugestões</a>
	      </div>
	    </div>
	    <div class="carousel-item" style="background-image: url('<?php echo $selectedImages[4]; ?>');">
	      <div class="carousel-caption d-block">
	        <h5>Faça Login</h5>
	        <p>Acesse sua conta para gerenciar suas receitas e avaliações.</p>
	        <a class="btn btn-primary" href="/TCC/src/usuario/login.php">Login</a>
	      </div>
	    </div>
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</body>

</html>