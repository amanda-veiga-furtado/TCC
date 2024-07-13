<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        font-family: Hack, monospace;
        }

        nav {
            width: 100%; /* Faz a navbar preencher toda a largura da tela */
            margin: 0px;
            /* background: red; */
            background: #f9f9f9;
            padding: 0px;
        }

        .menuItems {
            list-style: none;
            display: flex;
            justify-content: center; /* Centraliza os itens dentro da navbar */
        }

        .menuItems li {
            margin: 30px;
        }

.menuItems a {
  text-decoration: none;
  color: #8f8f8f;
  font-size: 24px;
  font-weight: 400;
  transition: all 0.5s ease-in-out;
  position: relative;
  text-transform: uppercase;
}

.menuItems a::before {
  content: attr(data-item);
  transition: 0.5s;
  color: #8254ff;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  width: 0;
  overflow: hidden;
}

.menuItems a:hover::before {
  width: 100%;
  transition: all 0.5s ease-in-out;
}

    </style>
</head>
<body>
<nav>
    <ul class="menuItems">
      <li><a href='#' data-item='Home'>Home</a></li>
      <li><a href='#' data-item='About'>About</a></li>
      <li><a href='#' data-item='Projects'>Projects</a></li>
      <li><a href='#' data-item='Blog'>Blog</a></li>
      <li><a href='#' data-item='Contact'>Contact</a></li>
    </ul>
  </nav>

</body>
</html>