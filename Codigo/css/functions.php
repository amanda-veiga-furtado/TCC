<?php
    // Função Mudar Imagem Aleatóriamente
        $images = range(start: 1,end: 31); // Array com o nome das imagens
        $randomImage = $images[array_rand($images)]; // Seleciona uma imagem aleatória    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9572f9bae9.js" crossorigin="anonymous"></script>
    <style>
        /*_________________________________________________________________________________________________

            Paleta de Cores
                Vermelho:   #fe797b (Primária),         #FC445D (Secundária);
                Laranja:    #ffb750 (Primária),         #f39c12 (Secundária);
                Amarelo:    #ffea56 (Primária),         #f1c40f (Secundária);
                Verde:      #8fe968 (Primária),         #7BDB47 (Secundária);
                Azul:       #36cedc (Primária),         #30B5C2 (Secundária);
                Roxo:       #a587ca (Primária),         #8c6db6 (Secundária);
                Cinza:      #f9f9f9 (Fundo Navbar),     #8f8f8f (Texto Navbar);
        _________________________________________________________________________________________________*/

        * {
            padding: 0; /* Remove o padding padrão de todos os elementos */
            margin: 0; /* Remove a margem padrão de todos os elementos */
            box-sizing: border-box; /* Inclui padding e border na largura e altura total dos elementos */
        }

        /*menu.php_______________________________________________________________________________________*/
            nav {
                display: flex; /* Usa flexbox para alinhar conteúdo verticalmente */
                flex-direction: column; /* Coluna principal */
                justify-content: center; /* Centraliza verticalmente */
                align-items: center; /* Centraliza horizontalmente */
                position: relative; /* Define a posição relativa para o body */
                font-family: Hack, monospace; /* Define a fonte para todo o documento */
                width: 100%; /* Faz a navbar preencher toda a largura da tela */
                margin: 0px; /* Margem zero para remover espaçamento padrão */
                background: #f9f9f9; /* Cor de fundo da barra de navegação */
                padding: 0px; /* Padding zero para remover espaçamento interno */
            }
            .menuItems {
                list-style: none; /* Remove marcadores de lista */
                display: flex; /* Usa flexbox para alinhar itens da lista */
                justify-content: center; /* Centraliza horizontalmente os itens da lista */
            }
            .menuItems li {
                display: flex; /* Adiciona flexbox ao li */
                align-items: center; /* Centraliza verticalmente os itens */
                margin: 30px; /* Margem entre os itens da lista */
                position: relative; /* Define a posição relativa para os itens da lista */
                text-align: center;
            }
            .menuItems a {
                text-decoration: none; /* Remove sublinhado dos links */
                color: #8f8f8f; /* Cor do texto dos links */
                font-size: 24px; /* Tamanho da fonte dos links */
                font-weight: 400; /* Peso normal da fonte */
                text-transform: uppercase; /* Transforma o texto em maiúsculas */
                position: relative; /* Define a posição relativa para os links */
            }
            .menuItems a::before {
                content: ''; /* Conteúdo vazio para o pseudoelemento ::before */
                position: absolute; /* Posição absoluta para o pseudoelemento */
                width: 100%; /* Largura total */
                height: 3px; /* Altura do traço arco-íris */
                bottom: -6px; /* Posicionamento abaixo do texto */
                background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); /* Gradiente arco-íris */
                visibility: hidden; /* Inicia invisível */
                transform: scaleX(0); /* Inicia sem largura (escala zero) */
                transition: transform 0.3s ease, visibility 0s linear 0.3s; /* Transição suave */
            }
            .menuItems a:hover::before {
                visibility: visible; /* Torna o traço visível ao passar o mouse */
                transform: scaleX(1); /* Expande o traço para a largura total do link */
                transition: transform 0.3s ease, visibility 0s linear; /* Transição suave */
            }

        /* Formulários___________________________________________________________________________________*/

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
        .container_form_type_2 {
            width: 100%;
            /* height: 85.3vh; */
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../css/img/fundo/<?php echo $randomImage; ?>.jpg')no-repeat center center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .whitecard_form {
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
        }
        .whitecard_form_type_2 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 710px;
            /* height: 410px; */
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 25px 30px 55px #5557;
            border-radius: 13px;
            overflow: hidden;
            margin-top: 8.45vh;
            margin-bottom: 8.45vh;
            }
        .form_switch {
            position: relative;
            width: 100%;
        }
        .form-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            width: 100%;
            position: relative;
        }
            .form-toggle2 {
                display: flex;
                justify-content: space-between;
                margin-bottom: 25px;
                margin-top: 25px;
                width: 100%;
                position: relative;
            } 
        /* Linha Colorida */
            .toggle-line-small {
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 50%;
                height: 3px;
                background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
                transition: transform 0.3s;
            }
            .toggle-line-big {
                position: absolute;
                bottom: -5px;
                left: 100%;
                width: 100%;
                height: 3px;
                background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca);
                transition: transform 0.3s;
                transform: translateX(-100%); /* Centraliza horizontalmente */
            }
            .form-toggle button,
            .form-toggle2 button {
                background: none;
                border: none;
                font-size: 20px;
                cursor: pointer;
                padding: 10px 20px;
                color: #888;
                transition: color 0.3s;
                flex-grow: 1;
                text-align: center;
            }
            .form-toggle2 button {
                font-size: 32px;
            }
            .form-toggle button:hover,
            .form-toggle2 button:hover,
            .form-toggle button:focus,
            .form-toggle2 button:focus {
                color: #333;
            }
            .div_form {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
        /* Texto_________________________________________________________________________________________*/
            .div_form h1 {
                color: #333;
                font-size: 28px;
                margin-top: 19px;
                margin-bottom: 1px;
            } 
            .div_form h2 {
                margin-bottom: 15px;
                color: #333;
                font-size: 24px;
                margin-top: 15px;
            }
            .div_form h3 {
                margin-bottom: 15px;
                color: #333;
                font-size: 20px;
            }
            p {
                margin: 5px;
                font-family: Arial;
                font-size: 15pt;
                font-weight: bold;
                /* background-color: gray; */
                color: white;
            }
            hr {
                border: none; /* Remove a borda padrão */
                height: 1px; /* Define a altura da linha */
                /* background: linear-gradient(90deg, #fe797b, #ffb750, #ffea56, #8fe968, #36cedc, #a587ca); */
                background-color: (54, 206, 220, 0.5);                      
            }


                            /* Imagens__________________________________________________*/
                                .lista-receita-imagem {
                                    /* background-position: center; */
                                    justify-content: center; /* centraliza os itens horizontalmente */
                                    align-items: center; /* centraliza os itens verticalmente */
                                    /* background-size: cover; */
                                    /* width: 100%; */
                                    width: 5%;
                                }
                                .banner {
                                    /* background-image: url(../css/img/receita/imagem.png); */
                                    background-position: center;
                                    background-size: cover;
                                    height: 300px;
                                }


        /* Inputs________________________________________________________________________________________*/
            .div_form input,
            input[type="text"],
            input[type="email"],
            input[type="password"] {
                margin-bottom: 15px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 16px;
                width: 100%;
                box-sizing: border-box;
            }
            .div_form textarea,
            input[type="textarea"] {
                margin-bottom: 15px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 16px;
                width: 100%;
                height: 600px;
                box-sizing: border-box;
            }
            .div_form select,
            input[type="select"] {
                margin-bottom: 15px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 16px;
                box-sizing: border-box;
            }  
            .div_form input:focus, .div_form select:focus, .div_form textarea:focus {
                border-color: #36cedc;
                outline: none;
            }  
            input[type="file"] {
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 8px;
                height: 46px; 
                padding: 0; 
                font-size: 16px;
                box-sizing: border-box;
                /* width: 49%; */
            }
                input[type="file"]::file-selector-button {
                    background-color: #36cedc;
                    border: none;
                    border-radius: 8px;
                    color: white;
                    padding: 10px;
                    /* width: 30%; */
                    cursor: pointer;
                    height: 100%; /* Ensures the button fills the input height */
                }
                input[type="file"]::file-selector-button:hover {
                    background-color: #30B5C2;
                }

        /* Botões________________________________________________________________________________________*/
            .button-container {
                display: flex;
                gap: 100px; /* Distância entre os botões */
            }
            .button-long{
                padding: 12px;
                border: none;
                border-radius: 8px;
                background-color: #a587ca;
                color: white;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
                width: 100%;
                justify-content: center; /* centraliza os itens horizontalmente */
                align-items: center; /* centraliza os itens verticalmente */
                text-align: center;
            }
            .button-short{
                padding: 12px;
                border: none;
                border-radius: 8px;
                background-color: #a587ca;
                color: white;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
                /* width: 34%;     */
                width: 100px;
                justify-content: center; /* centraliza os itens horizontalmente */
                align-items: center; /* centraliza os itens verticalmente */
                text-align: center;
            }
                .button-long,.button-short:hover {
                    background-color: #8c6db6;
                }
            .button-search{
                padding: 12px;
                border: none;
                border-radius: 8px;
                background-color: #36cedc;
                color: white;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
                width: 10%;    
                height: 40px;
                justify-content: center; /* centraliza os itens horizontalmente */
                align-items: center; /* centraliza os itens verticalmente */
                text-align: center;
            }
            .button-search:hover{
                background-color: #30B5C2;

            }
     

            
            /* Botões + e - _____________________________________________________________________________*/

                .button-round {
                border: none;
                color: white;
                padding: 0; /* Remova o padding para usar flexbox */
                text-align: center;
                text-decoration: none;
                display: inline-block;
                /*display: flex;*/
                justify-content: center; /* Centraliza horizontalmente */
                align-items: center; /* Centraliza verticalmente */
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
        /* Link__________________________________________________________________________________________*/
            .div_link{
                /* margin-top: 0.3cm; */
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
        /* Paginação_____________________________________________________________________________________*/
            .div_pagination {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                /* background-color: #f9f9f9; */
                display: flex;
                justify-content: center;
                align-items: center;
                height: 10vh;
            }
                .pagination {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        gap: 10px;
                        padding: 10px;
                }
                    .pagination a {
                        color: #fff;
                        background-color: #a587ca;
                        opacity: 0.7;
                        border-radius: 25px;
                        padding: 8px 16px;
                        margin: 0 5px;
                        text-decoration: none;
                        font-size: 14px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra leve para um toque delicado */
                        transition: all 0.3s ease;
                        width: 40px;

                    }
                    .pagination a:hover {
                        background-color: #8c6db6; 
                        transform: translateY(-2px); /* Efeito de leve elevação */
                    }

                    .pagination a.active {
                        background-color: #36cedc; /* Azul Primário */
                        color: #fff;
                    }

                    .pagination a:first-child,.pagination a:last-child {
                        font-size: 16px;
                        padding: 8px 12px;
                        width: 90px;
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
    </body>
</html>