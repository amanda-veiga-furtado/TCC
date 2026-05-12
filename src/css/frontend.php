<?php
include_once 'paleta_cores.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9572f9bae9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Símbolos -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --><!-- Campo Select Pesquisar Digitando -->
    <style>
        /* Reset */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Paleta de Cores */


        /* Fundo */
        <?php
        //Função Mudar Imagem Aleatóriamente
        $images = range(start: 1, end: 32); // Array com o nome das imagens
        $randomImage = $images[array_rand($images)]; // Seleciona uma imagem aleatória    
        ?>
        .container_background_image_small {
            width: 100vw;
            height: 70.6vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /*background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;*/
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container_background_image_medium {
            width: 100vw;
            height: 85.3vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /*background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;*/
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container_background_image_grow {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container_background_image_grow_2 {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Containers */
        .container_whitecard_small {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 710px;
            height: 343px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            margin-top: 8.45vh;
            margin-bottom: 8.45vh;
        }

        .container_whitecard_grow {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 710px;
            min-height: 410px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            margin-top: 8.45vh;
            margin-bottom: 8.45vh;
        }

        .whitecard_form_type_1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 710px;
            height: 410px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            margin-top: 8.45vh;
            margin-bottom: 8.45vh;
            /* Cartão Branco no meio da pagina */
        }

        .container_form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 96%;
            height: 93.5%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 1.9vh;
        }

        .form_switch {
            position: relative;
            width: 100%;
            height: 100%;
            /* background-color: black; */
            /* margin-top: 0.5vh;
                margin-bottom: 5vh; */
        }

        .form-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 28px;
            width: 100%;
            position: relative;
            /* background-color: red; */
        }

        /* Formulários */
        .form-title-big {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            margin-top: 25px;
            width: 100%;
            position: relative;
        }

        .form-toggle button,
        .form-title-big button {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            padding: 10px 20px;
            color: #888;
            transition: color 0.3s;
            flex-grow: 1;
            text-align: center;
        }

        .form-title-big button {
            font-size: 32px;
        }

        .form-toggle button:hover,
        .form-title-big button:hover,
        .form-toggle button:focus,
        .form-title-big button:focus {
            color: #333;
        }

        /* Linha Colorida */
        .toggle-line-big {
            position: absolute;
            bottom: -5px;
            left: 100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario));
            transition: transform 0.3s;
            transform: translateX(-100%);
        }

        .toggle-line-small {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario));
            transition: transform 0.3s;
        }

        /* Cards */
        .projcard {
            position: relative;
            width: 90%;
            height: 220px;
            margin-bottom: 30px;
            border-radius: 10px;
            background-color: white;
            border: 2px solid #ddd;
            font-size: 18px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 21px -12px rgba(0, 0, 0, .66);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .projcard-small {
            position: relative;
            width: 90%;
            height: 160px;
            margin-bottom: 30px;
            border-radius: 10px;
            background-color: white;
            border: 2px solid #ddd;
            font-size: 18px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 21px -12px rgba(0, 0, 0, .66);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            align-items: center;
            align-content: center;
            justify-content: center;
        }

        .projcard:hover,
        .projcard-small:hover {
            box-shadow: 0 34px 32px -33px rgba(0, 0, 0, .18);
            transform: translate(0px, -3px);
        }

        .projcard-bar {
            left: -2px;
            width: 100%;
            height: 3px;
            margin: 10px 0;
            border-radius: 5px;
            background: linear-gradient(90deg, var(--vermelho-primario), var(--laranja-primario), var(--amarelo-primario), var(--verde-primario), var(--azul-primario), var(--roxo-primario));
            transition: transform 0.3s;
        }

        .projcard-container {
            margin: 15px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .projcard-container,
        .projcard-container * {
            box-sizing: border-box;
        }

        .projcard-container {
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }

        .projcard::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.07;
        }

        .projcard-innerbox {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .projcard-img {
            position: absolute;
            height: 100%;
            width: 40%;
            top: 0;
            left: 0;
            background-color: #f0f0f0;
            transition: transform 0.2s ease;
        }

        .projcard:nth-child(2n) .projcard-img {
            left: initial;
            right: 0;
        }

        .projcard:nth-child(2n) {
            left: initial;
            right: 0;
        }

        .projcard-textbox {
            position: absolute;
            top: 7%;
            bottom: 7%;
            left: calc(40% + 30px);
            width: calc(60% - 30px);
            font-size: 17px;
            padding-right: 30px;
        }

        .projcard:nth-child(2n) .projcard-textbox {
            left: 0;
            right: calc(60% + 30px);
            padding-left: 30px;
        }

        .projcard-textbox::before,
        .projcard-textbox::after {
            content: "";
            position: absolute;
            display: block;
            background: white;
            top: -20%;
            left: -55px;
            height: 140%;
            width: 60px;
            transform: rotate(8deg);
        }

        .projcard:nth-child(2n) .projcard-textbox::before {
            display: none;
        }

        .projcard-textbox::after {
            display: none;
            left: initial;
            right: -55px;
        }

        .projcard:nth-child(2n) .projcard-textbox::after {
            display: block;
        }

        .projcard-textbox * {
            position: relative;
        }

        .projcard-title {
            font-size: 24px;
        }

        .projcard-subtitle {
            color: #888;
        }

        .projcard-subtitle-2 {
            color: #888;
            font-size: 24px;
        }

        .projcard-description,
        projcard-description:nth-child(2n) {
            z-index: 10;
            font-size: 16px;
            color: #888;
            height: 125px;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: justify;
            text-justify: inter-word;
        }

        .projcard-tagbox {
            position: absolute;
            bottom: 3%;
            font-size: 14px;
            cursor: default;
            user-select: none;
            pointer-events: none;
        }

        .projcard-tag {
            display: inline-block;
            background: #F2F2F2;
            color: #777;
            border-radius: 3px 0 0 3px;
            line-height: 26px;
            padding: 0 5px 0 10px;
            position: relative;
            margin-right: 20px;
            cursor: default;
            user-select: none;
            transition: color 0.2s;
        }

        .projcard-tag::before {
            content: '';
            position: absolute;
            background: white;
            border-radius: 10px;
            box-shadow: inset 0 1px rgba(0, 0, 0, 0.25);
            height: 6px;
            left: 10px;
            width: 6px;
            top: 10px;
        }

        .projcard-tag::after {
            content: '';
            position: absolute;
            border-bottom: 13px solid transparent;
            border-left: 10px solid #F2F2F2;
            border-top: 13px solid transparent;
            right: -10px;
            top: 0;
        }

        /* Inputs */
        .container_form input[type="text"],
        .container_form input[type="email"],
        .container_form input[type="password"],
        .container_form input[type="number"],
        .container_form textarea,
        .container_form select {
            margin-bottom: 17px;
            padding: 12px;
            border: 1px solid rgba(143, 143, 143, 0.5);
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            width: 100%;
            box-sizing: border-box;
            height: 46px;
            background-color: white;
            color: var(--cinza-secundario);
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .container_form textarea {
            height: 460px;
        }

        input[type="file"] {
            margin-bottom: 15px;
            border: 1px solid rgba(143, 143, 143, 0.5);
            border-radius: 8px;
            height: 46px;
            padding: 0;
            font-size: 16px;
            box-sizing: border-box;
            width: 100%;
        }

        input[type="file"]::file-selector-button {
            background-color: #36cedc;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 10px;
            cursor: pointer;
            height: 100%;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: #30B5C2;
        }

        input[type="text"]:focus,
        .container_form input[type="email"]:focus,
        .container_form input[type="password"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: var(--azul-primario);
            outline: none;
        }

        /* Select Customizado */
        .js-example-basic-single {
            margin-bottom: 17px;
            padding: 12px !important;
            border: 1px solid rgba(143, 143, 143, 0.5);
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            width: 100%;
            box-sizing: border-box;
            height: 46px;
            background-color: white;
            color: var(--cinza-secundario);
            transition: background-color 0.3s, border-color 0.3s;
        }

        #search-input,
        #ingredient-select {
            margin-bottom: 10px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border: 1px solid rgba(143, 143, 143, 0.5) !important;
            border-radius: 15px !important;
            background-color: white;
            color: rgba(143, 143, 143, 0.5) !important;
            transition: border-color 0.3s;
        }

        #search-input:focus,
        #ingredient-select:focus {
            border-color: var(--azul-primario) !important;
        }

        .whitecard_form_type_1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 710px;
            height: 410px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            margin-top: 8.45vh;
            margin-bottom: 8.45vh;
        }

        /* Carrinho */
        .cart-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: var(--vermelho-primario);
            cursor: pointer;
            z-index: 10;
        }

        .cart-close:hover,
        .cart-close:focus {
            color: var(--vermelho-secundario);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Texto */
        .container_form h1,
        .h1 {
            color: #333;
            font-size: 28px;
            margin-top: 19px;
            margin-bottom: 1px;
        }

        .container_form h2,
        .h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 24px;
            margin-top: 15px;
        }

        .container_form h3,
        .h3 {
            margin-bottom: 10px;
            color: #333;
            font-size: 20px;
        }

        .container_form p,
        .p {
            margin: 5px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15pt;
            font-weight: bold;
            color: white;
        }

        .container_form hr,
        hr {
            border: none;
            height: 1px;
            background-color: rgba(54, 206, 220, 0.5);
        }

        /* Botões */
        .button-search {
            padding: 12px !important;
            border: none;
            border-radius: 8px;
            background-color: #36cedc;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 10%;
            height: 40px;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-search:hover {
            background-color: #30B5C2;
        }

        .container-buttons {
            display: flex;
            gap: 100px;
        }

        .button-short {
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

        .button-long {
            background-color: var(--roxo-primario);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-long:hover,
        .button-short:hover {
            background-color: #8c6db6;
        }

        .button-yellow {
            background-color: var(--amarelo-primario);
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-yellow:hover {
            background-color: var(--amarelo-secundario);
        }

        .button-red {
            background-color: var(--vermelho-primario);
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-red:hover {
            background-color: var(--vermelho-secundario);
        }

        .button-orange {
            background-color: var(--laranja-primario);
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-orange:hover {
            background-color: var(--laranja-secundario);
        }

        .button-purple {
            background-color: var(--roxo-primario);
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .button-purple:hover {
            background-color: var(--roxo-secundario);
        }

        .button-round {
            border: none;
            color: white;
            padding: 0;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }

        .button-plus {
            background-color: #8fe968;
        }

        .button-plus:hover {
            background-color: #7BDB47;
        }

        .button-minus {
            background-color: #fe797b;
        }

        .button-minus:hover {
            background-color: #FC445D;
        }

        /* Links */
        .div_link {
            margin-top: 0.1cm;
            text-align: center;
        }

        a {
            color: #8c6db6;
            text-decoration: none;
        }

        a.forgot {
            padding-bottom: 3px;
            border-bottom: 2px solid #a587ca;
        }

        .form_switch {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .form-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 28px;
            width: 100%;
            position: relative;
        }

        /* Paginação */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 10px;
        }

        .pagination a {
            color: white;
            background-color: #a587ca;
            border-radius: 100px;
            padding: 10px 20px;
            margin: 0 4px;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 40px;
        }

        .pagination a:hover {
            background-color: #8c6db6;
        }

        .pagination a.active,
        .active {
            background-color: #36cedc;
            pointer-events: none;
        }

        .pagination a:first-child:not(.active),
        .pagination a:last-child:not(.active) {
            padding: 8px 18px;
            width: 85px;
        }

        /* Imagens */
        .lista-receita-imagem {
            justify-content: center;
            align-items: center;
            width: 5%;
        }

        .banner {
            background-position: center;
            background-size: cover;
            height: 300px;
        }

        /* Carousel Home */
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .carousel-caption p {
            font-size: 1.2rem;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
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
    <script>
        // login.php (css)
        function showLogin() {
            document.getElementById('loginForm').style.display = 'block'; // Mostra o formulário de login -->
            document.getElementById('signupForm').style.display = 'none'; // Esconde o formulário de cadastro 
            document.getElementById('toggleLine').style.transform = 'translateX(0)'; // Move a linha indicadora para a posição do login
        }
        function showSignup() {
            document.getElementById('loginForm').style.display = 'none'; // Esconde o formulário de login -->
            document.getElementById('signupForm').style.display = 'block'; // Mostra o formulário de cadastro 
            document.getElementById('toggleLine').style.transform = 'translateX(100%)'; // Move a linha indicadora para a posição do cadastro
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const colors = [
                "#FFBEF5", "#FFB6D6", "#FFB3BA", "#FFC8B3", "#FFDFBA", 
                "#FFEEB8", "#FFFFBA", "#DEFFBD", "#BAFFC9", "#99F5F7", 
                "#BAE1FF", "#C1D0FF", "#E7B7FF", "#E0A0FF", "#D889FF"
            ];

            function setRandomBackground() {
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                document.body.style.backgroundColor = randomColor;
            }

            setRandomBackground();
        });
    </script>
</body>

</html>