-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23/08/2024 às 20:13
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc_receitas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria_ingrediente`
--

DROP TABLE IF EXISTS `categoria_ingrediente`;
CREATE TABLE IF NOT EXISTS `categoria_ingrediente` (
  `id_categoria_ingrediente` int NOT NULL AUTO_INCREMENT,
  `nome_categoria_ingrediente` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categoria_ingrediente`),
  UNIQUE KEY `unique_nome_categoria_ingrediente` (`nome_categoria_ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `categoria_ingrediente`
--

INSERT INTO `categoria_ingrediente` (`id_categoria_ingrediente`, `nome_categoria_ingrediente`) VALUES
(16, 'Açúcares, Adoçantes e Aditivos'),
(12, 'Aves'),
(27, 'Bebidas com álcool'),
(28, 'Bebidas sem álcool'),
(11, 'Carnes'),
(3, 'Cogumelos e Fungos'),
(23, 'Conservas Vegetais'),
(10, 'Cortes Frios'),
(15, 'Especiarias'),
(19, 'Farinhas, Fermentos e Leveduras'),
(18, 'Flores Comestíveis'),
(4, 'Frutas'),
(6, 'Frutas Secas e Nozes'),
(14, 'Frutos do Mar, Mariscos e Crustáceos'),
(5, 'Geleias e Frutas em Conserva'),
(2, 'Hortaliças e Verduras'),
(1, 'Ingredientes Essenciais'),
(8, 'Laticínios e Ovos'),
(21, 'Massas'),
(24, 'Molhos e Condimentos'),
(22, 'Óleos, Gorduras e Vinagres'),
(29, 'Padaria'),
(13, 'Pescados'),
(17, 'Pimentas Quentes'),
(7, 'Queijos'),
(20, 'Sementes, Grãos, Cereais e Leguminosas'),
(26, 'Sobremesa, Salgadinhos e Guloseimas'),
(25, 'Sopas e Caldos'),
(9, 'Veganos e Vegetarianos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `qtd_estrelas` tinyint DEFAULT NULL,
  `texto_comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_comentario` date DEFAULT NULL,
  `fk_id_receita` int DEFAULT NULL,
  `fk_id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `fk_id_usuario` (`fk_id_usuario`),
  KEY `fk_id_receita` (`fk_id_receita`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
CREATE TABLE IF NOT EXISTS `ingrediente` (
  `id_ingrediente` int NOT NULL AUTO_INCREMENT,
  `nome_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagem_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '../css/img/ingrediente/no_image.png',
  PRIMARY KEY (`id_ingrediente`),
  UNIQUE KEY `nome_ingrediente` (`nome_ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nome_ingrediente`, `imagem_ingrediente`) VALUES
(1, 'Abacate', '../css/img/ingrediente/1.png'),
(2, 'Abacaxi', '../css/img/ingrediente/2.png'),
(3, 'Açaí (Fruta)', '../css/img/ingrediente/3.png'),
(4, 'Banana', '../css/img/ingrediente/4.png'),
(5, 'Goiaba', '../css/img/ingrediente/5.png'),
(6, 'Kiwi', '../css/img/ingrediente/6.png'),
(7, 'Laranja', '../css/img/ingrediente/7.png'),
(8, 'Limão', '../css/img/ingrediente/8.png'),
(9, 'Maçã', '../css/img/ingrediente/9.png'),
(10, 'Mamão', '../css/img/ingrediente/10.png'),
(12, 'Abiu', '../css/img/ingrediente/12.png'),
(13, 'Ameixa', '../css/img/ingrediente/13.png'),
(17, 'Abacaxi Pérola', '../css/img/ingrediente/2.png'),
(18, 'Abacaxi Havaí', '../css/img/ingrediente/2.png'),
(19, 'Ovo', '../css/img/ingrediente/no_image.png'),
(21, 'Polpa de Açaí', '../css/img/ingrediente/3.png'),
(23, 'Banana Verde', '../css/img/ingrediente/4.png'),
(24, 'Banana Da Terra', '../css/img/ingrediente/4.png'),
(25, 'Banana Nanica', '../css/img/ingrediente/4.png'),
(26, 'Banana Prata', '../css/img/ingrediente/4.png'),
(31, 'Kiwi Dourado / Kiwi Amarelo', '../css/img/ingrediente/6.png'),
(32, 'Goiaba Branca', '../css/img/ingrediente/5.png'),
(33, 'Goiaba Vermelha', '../css/img/ingrediente/5.png'),
(34, 'Laranja Lima', '../css/img/ingrediente/7.png'),
(35, 'Laranja Pera', '../css/img/ingrediente/7.png'),
(36, 'Limão Taiti', '../css/img/ingrediente/8.png'),
(38, 'Limão Siciliano', '../css/img/ingrediente/8.png'),
(42, 'Maçã Fuji', '../css/img/ingrediente/9.png'),
(43, 'Maçã Gala', '../css/img/ingrediente/9.png'),
(44, 'Maçã Granny Smith', '../css/img/ingrediente/9.png'),
(45, 'Maçã Red Argentina', '../css/img/ingrediente/9.png'),
(46, 'Mamão Formosa', '../css/img/ingrediente/10.png'),
(47, 'Mamão Papaya', '../css/img/ingrediente/10.png'),
(48, 'Ameixa Sem Caroço', '../css/img/ingrediente/13.png'),
(49, 'Polpa de Abacaxi', '../css/img/ingrediente/2.png'),
(50, 'Polpa de Abiu', '../css/img/ingrediente/12.png'),
(52, 'Ameixa Preta', '../css/img/ingrediente/13.png'),
(53, 'Polpa de Ameixa Preta', '../css/img/ingrediente/13.png'),
(54, 'Polpa de Ameixa', '../css/img/ingrediente/13.png'),
(55, 'Polpa de Banana', '../css/img/ingrediente/4.png'),
(56, 'Polpa de Goiaba', '../css/img/ingrediente/5.png'),
(58, 'Gelatina em Pó Sabor Algodão Doce', '../css/img/ingrediente/58.jpg'),
(59, 'Gelatina em Pó Sabor Amora', '../css/img/ingrediente/no_image.png'),
(60, 'Gelatina em Pó Sabor Açaí com Banana', '../css/img/ingrediente/no_image.png'),
(61, 'Gelatina em Pó Sabor Morango', '../css/img/ingrediente/61.jpg'),
(62, 'Gelatina em Pó Sabor Uva\n', '../css/img/ingrediente/62.jpg'),
(71, 'Gelatina em Pó Sabor Abacaxi', '../css/img/ingrediente/71.jpg'),
(72, 'Gelatina em Pó Sabor Cereja', '../css/img/ingrediente/61.jpg'),
(75, 'Gelatina em Pó Sabor Tutti-Frutti', '../css/img/ingrediente/75.jpg'),
(76, 'Gelatina em Pó Sabor Framboesa', '../css/img/ingrediente/61.jpg'),
(77, 'Gelatina em Pó Sabor Limão', '../css/img/ingrediente/77.jpg'),
(78, 'Gelatina em Pó Sabor Cereja com Amora Silvestre', '../css/img/ingrediente/no_image.png'),
(83, 'Gelatina em Pó Sabor Maracujá', '../css/img/ingrediente/71.jpg'),
(84, 'Gelatina em Pó Sabor Pessego', '../css/img/ingrediente/71.jpg'),
(87, 'Gelatina Incolor Sem Sabor', '../css/img/ingrediente/87.png'),
(88, 'Leite Condensado / Leite Moça', '../css/img/ingrediente/88.png'),
(89, 'Creme de Leite', '../css/img/ingrediente/89.png'),
(90, 'Leite Condensado / Leite Moça (Sem Lactose)', '../css/img/ingrediente/88.png'),
(91, 'Creme de Leite (Sem Lactose)', '../css/img/ingrediente/89.png'),
(92, 'Gelatina em Pó de Qualquer Sabor', '../css/img/ingrediente/92.png'),
(94, 'Água', '../css/img/ingrediente/94.png'),
(95, 'Água com Gás', '../css/img/ingrediente/94.png'),
(96, 'Água Alcalina', '../css/img/ingrediente/94.png'),
(97, 'Sal', '../css/img/ingrediente/87.png'),
(98, 'Açúcar', '../css/img/ingrediente/87.png'),
(101, 'Sal Refinado', '../css/img/ingrediente/87.png'),
(102, 'Sal Marinho', '../css/img/ingrediente/87.png'),
(103, 'Sal do Himalaia', '../css/img/ingrediente/87.png'),
(104, 'Pedra de Sal Rosa do Himalaia', '../css/img/ingrediente/87.png'),
(105, 'Flor de Sal', '../css/img/ingrediente/87.png'),
(106, 'Sal Kosher', '../css/img/ingrediente/87.png'),
(107, 'Sal Maldon', '../css/img/ingrediente/87.png'),
(108, 'Sal Light', '../css/img/ingrediente/87.png'),
(109, 'Açúcar Cristal', '../css/img/ingrediente/87.png'),
(110, 'Açúcar Refinado', '../css/img/ingrediente/87.png'),
(111, 'Açúcar Mascavo', '../css/img/ingrediente/87.png'),
(112, 'Açúcar Demerara', '../css/img/ingrediente/112.png'),
(113, 'Açúcar de Coco', '../css/img/ingrediente/87.png'),
(114, 'Açúcar Light', '../css/img/ingrediente/87.png'),
(115, 'Flocos de Aveia', '../css/img/ingrediente/no_image.png'),
(117, 'Whiskey Teor 100', '../css/img/ingrediente/no_image.png'),
(118, 'Whiskey Teor 80', '../css/img/ingrediente/no_image.png'),
(119, 'Whiskey', '../css/img/ingrediente/no_image.png'),
(120, 'Whiskey Teor 86', '../css/img/ingrediente/no_image.png'),
(121, 'Whiskey Teor 90', '../css/img/ingrediente/no_image.png'),
(122, 'Whiskey Teor 94', '../css/img/ingrediente/no_image.png'),
(135, 'Vodka Teor 94', '../css/img/ingrediente/no_image.png'),
(136, 'Vodka Teor 90', '../css/img/ingrediente/no_image.png'),
(137, 'Vodka Teor 80', '../css/img/ingrediente/no_image.png'),
(138, 'Vodka Teor 100', '../css/img/ingrediente/no_image.png'),
(139, 'Vinho', '../css/img/ingrediente/no_image.png'),
(140, 'Vinho Tinto', '../css/img/ingrediente/no_image.png'),
(141, 'Vinho Rosé', '../css/img/ingrediente/no_image.png'),
(142, 'Vinho Moscatel', '../css/img/ingrediente/no_image.png'),
(143, 'Vinho de Maçã', '../css/img/ingrediente/no_image.png'),
(144, 'Vinho de Jenipapo', '../css/img/ingrediente/no_image.png'),
(145, 'Vinho Branco Seco', '../css/img/ingrediente/no_image.png'),
(146, 'Vinho Branco Médio', '../css/img/ingrediente/no_image.png'),
(147, 'Vinho Aperitivo Seco', '../css/img/ingrediente/no_image.png'),
(148, 'Vinho Aperitivo Doce', '../css/img/ingrediente/no_image.png'),
(163, 'Arroz', '../css/img/ingrediente/no_image.png'),
(164, 'Arroz Agulhinha', '../css/img/ingrediente/no_image.png'),
(165, 'Arroz Arbóreo', '../css/img/ingrediente/no_image.png'),
(167, 'Arroz Basmati', '../css/img/ingrediente/no_image.png'),
(168, 'Arroz Branco', '../css/img/ingrediente/no_image.png'),
(170, 'Arroz Cateto', '../css/img/ingrediente/no_image.png'),
(171, 'Arroz Integral', '../css/img/ingrediente/no_image.png'),
(172, 'Arroz Japonês', '../css/img/ingrediente/no_image.png'),
(173, 'Arroz Jasmim', '../css/img/ingrediente/no_image.png'),
(174, 'Arroz Negro', '../css/img/ingrediente/no_image.png'),
(175, 'Arroz Parboilizado', '../css/img/ingrediente/no_image.png'),
(176, 'Arroz Selvagem', '../css/img/ingrediente/no_image.png'),
(177, 'Arroz Vermelho', '../css/img/ingrediente/no_image.png'),
(188, 'Leite', '../css/img/ingrediente/no_image.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_de_ingredientes`
--

DROP TABLE IF EXISTS `lista_de_ingredientes`;
CREATE TABLE IF NOT EXISTS `lista_de_ingredientes` (
  `fk_id_receita` int DEFAULT NULL,
  `fk_id_ingrediente` int DEFAULT NULL,
  `qtdIngrediente_lista` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `FK_lista_de_ingredientes_1` (`fk_id_receita`),
  KEY `FK_lista_de_ingredientes_2` (`fk_id_ingrediente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `lista_de_ingredientes`
--

INSERT INTO `lista_de_ingredientes` (`fk_id_receita`, `fk_id_ingrediente`, `qtdIngrediente_lista`) VALUES
(60, 3, '2 quilograma(s)'),
(61, 95, '1 colher(es) de café'),
(61, 96, '1 colher(es) de café'),
(61, 118, '1 colher(es) de café'),
(61, 48, '1 colher(es) de café'),
(62, 95, '1 colher(es) de café'),
(62, 96, '1 colher(es) de café'),
(62, 118, '1 colher(es) de café'),
(62, 48, '1 colher(es) de café'),
(63, 95, '1 colher(es) de café'),
(63, 96, '1 colher(es) de café'),
(63, 118, '1 colher(es) de café'),
(63, 48, '1 colher(es) de café'),
(93, 98, '1 grama(s)'),
(93, 1, '1 colher(es) de café'),
(93, 17, '1 colher(es) de café'),
(94, 96, '4 e 1/2 punhado(s)'),
(94, 13, '1 '),
(95, 96, '4 e 1/2 punhado(s)'),
(95, 13, '1 '),
(96, 96, '4 e 1/2 punhado(s)'),
(96, 13, '1 '),
(107, 111, '1 xícara(s) de chá'),
(107, 48, '1 '),
(108, 111, '1 xícara(s) de chá'),
(108, 48, '1 '),
(109, 111, '1 xícara(s) de chá'),
(109, 48, '1 '),
(110, 13, '1 colher(es) de café'),
(110, 95, '1 '),
(111, 13, '1 colher(es) de café'),
(111, 95, '1 '),
(112, 13, '1 colher(es) de café'),
(112, 95, '1 '),
(116, 94, '1 colher(es) de café'),
(116, 52, '1 a gosto'),
(117, 12, '1 colher(es) de café'),
(119, 163, '1 colher(es) de café'),
(119, 163, '1 colher(es) de café'),
(120, 163, '1 colher(es) de café'),
(120, 163, '1 colher(es) de café'),
(124, NULL, 'Array Array'),
(125, NULL, '1 Array'),
(128, 96, '1 colher(es) de café'),
(129, 114, '1 colher(es) de café'),
(130, 17, '1 colher(es) de café'),
(131, 96, '1 colher(es) de café'),
(134, 96, '1 colher(es) de café'),
(142, 96, '1 pacote(s)'),
(154, 96, '1 colher(es) de café'),
(154, 48, '1 colher(es) de café'),
(155, 96, '1 colher(es) de café'),
(155, 48, '1 colher(es) de café'),
(156, 52, '1 colher(es) de café'),
(157, 52, '1 colher(es) de café'),
(158, 52, '1 colher(es) de café'),
(159, 52, '1 colher(es) de café'),
(160, 52, '1 colher(es) de café'),
(161, 52, '1 colher(es) de café'),
(162, 52, '1 colher(es) de café'),
(163, 52, '1 colher(es) de café'),
(164, 52, '1 colher(es) de café'),
(165, 52, '1 colher(es) de café'),
(166, 110, '1 colher(es) de café');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receita`
--

DROP TABLE IF EXISTS `receita`;
CREATE TABLE IF NOT EXISTS `receita` (
  `id_receita` int NOT NULL AUTO_INCREMENT,
  `nome_receita` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `numeroPorcao_receita` decimal(65,4) NOT NULL,
  `tipoPorcao_receita` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempoPreparo_receita` varchar(23) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `modoPreparo_receita` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagem_receita` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_receita`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `receita`
--

INSERT INTO `receita` (`id_receita`, `nome_receita`, `numeroPorcao_receita`, `tipoPorcao_receita`, `tempoPreparo_receita`, `modoPreparo_receita`, `imagem_receita`) VALUES
(167, '1', 2.0000, '3', '4', '5', '6'),
(168, '1', 2.0000, '3', '4', '5', '6'),
(169, '1', 2.0000, '3', '4', '5', '6'),
(170, '1', 2.0000, '3', '4', '5', '6'),
(171, '1', 2.0000, '3', '4', '5', '6'),
(172, '1', 2.0000, '3', '4', '5', '6'),
(173, '1', 2.0000, '3', '4', '5', '6'),
(174, '1', 2.0000, '3', '4', '5', '6'),
(175, '1', 2.0000, '3', '4', '5', '6'),
(176, '1', 2.0000, '3', '4', '5', '6'),
(177, '1', 2.0000, '3', '4', '5', '6'),
(178, '1', 2.0000, '3', '4', '5', '6'),
(179, '1', 2.0000, '3', '4', '5', '6'),
(180, '1', 2.0000, '3', '4', '5', '6'),
(181, '1', 2.0000, '3', '4', '5', '6'),
(182, '1', 2.0000, '3', '4', '5', '6');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sugestao`
--

DROP TABLE IF EXISTS `sugestao`;
CREATE TABLE IF NOT EXISTS `sugestao` (
  `id_sugestao` int NOT NULL AUTO_INCREMENT,
  `nome_sugestao` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_sugestao` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_sugestao`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sugestao`
--

INSERT INTO `sugestao` (`id_sugestao`, `nome_sugestao`, `categoria_sugestao`) VALUES
(24, 'Leite', 'Ingrediente'),
(25, 'Vegetais', 'Categoria de Ingrediente'),
(26, 'Japonesa', 'Categoria Culinaria'),
(27, 'teste03/06', 'Categoria de Ingrediente'),
(28, 'mandioca', 'Ingrediente'),
(29, 'Oriental', 'Categoria Culinaria'),
(30, 'mandioca', 'Ingrediente'),
(31, 'Oriental', 'Categoria Culinaria'),
(32, 'mandioca', 'Ingrediente'),
(33, 'Oriental', 'Categoria Culinaria'),
(34, 'mandioca', 'Ingrediente'),
(35, 'Oriental', 'Categoria Culinaria'),
(36, 'mandioca', 'Ingrediente'),
(37, 'Oriental', 'Categoria Culinaria'),
(38, 'mandioca', 'Ingrediente'),
(39, 'Oriental', 'Categoria Culinaria');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagem_usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `recuperar_senha`, `imagem_usuario`) VALUES
(144, 'a@a.com', 'a@a.com', '$2y$10$Pl5gLBdV86k2Nb5Dm8/o.utGzhEdLmtpcFfrjXZc7FayVeWFVYvpa', NULL, ''),
(145, 'aamanda18/08', 'amanda@amanda.com', '$2y$10$c3utx84Ax62ZmkBqLxBFEuSWVYwtIKM5omBfbnNlhvrsXamX7eBJa', NULL, ''),
(146, '666666666', '6666666@66.com', '$2y$10$UsUad9wUKQEL.WrODIUx2uAqIYywhrASr01XtiDIsfpe/YUZ4wr8G', NULL, ''),
(147, 'aaaaaa99', 'aaaaaa99@aaaaaa99.com', '$2y$10$C8T6LTOZVrdokTgqxgKsw.dDdsHOv7iuTAiXnh6HyNQpXBkR9c91K', NULL, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
