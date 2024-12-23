-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29/11/2024 às 02:21
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
-- Estrutura para tabela `categoria_culinaria`
--

DROP TABLE IF EXISTS `categoria_culinaria`;
CREATE TABLE IF NOT EXISTS `categoria_culinaria` (
  `id_categoria_culinaria` int NOT NULL AUTO_INCREMENT,
  `nome_categoria_culinaria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categoria_culinaria`),
  UNIQUE KEY `nome_categoria_culinaria` (`nome_categoria_culinaria`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categoria_culinaria`
--

INSERT INTO `categoria_culinaria` (`id_categoria_culinaria`, `nome_categoria_culinaria`) VALUES
(44, ' Sem Categoria'),
(39, 'Alimentação Saudável'),
(34, 'Aperitivos e Petiscos'),
(25, 'Bebidas'),
(36, 'Bolos e Tortas Doces'),
(35, 'Conservas e Compotas'),
(20, 'Culinária Alemã'),
(17, 'Culinária Argentina'),
(10, 'Culinária Brasileira'),
(5, 'Culinária Chinesa'),
(11, 'Culinária Coreana'),
(9, 'Culinária Espanhola'),
(15, 'Culinária Etíope'),
(2, 'Culinária Francesa'),
(12, 'Culinária Grega'),
(6, 'Culinária Indiana'),
(1, 'Culinária Italiana'),
(3, 'Culinária Japonesa'),
(8, 'Culinária Libanesa'),
(13, 'Culinária Marroquina'),
(4, 'Culinária Mexicana'),
(45, 'Culinária Nipo-Brasileira'),
(16, 'Culinária Peruana'),
(19, 'Culinária Russa'),
(7, 'Culinária Tailandesa'),
(14, 'Culinária Turca'),
(18, 'Culinária Vietnamita'),
(29, 'Doces e Sobremesas'),
(28, 'Fitness'),
(33, 'Gourmet'),
(27, 'Low Carb'),
(37, 'Peixes e Frutos do Mar'),
(32, 'Receitas para Crianças'),
(31, 'Receitas Rápidas'),
(30, 'Receitas Saudáveis'),
(41, 'Recheios e Coberturas'),
(38, 'Salada, Molhos e Acompanhamentos'),
(24, 'Sem Glúten'),
(40, 'Sem Glúten e Sem Lactose'),
(23, 'Sem Lactose'),
(21, 'Vegano'),
(22, 'Vegetariano'),
(26, 'Vitaminas');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `texto_comentario` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data_comentario` date DEFAULT NULL,
  `fk_id_receita` int DEFAULT NULL,
  `fk_id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `fk_id_usuario` (`fk_id_usuario`),
  KEY `fk_id_receita` (`fk_id_receita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
CREATE TABLE IF NOT EXISTS `ingrediente` (
  `id_ingrediente` int NOT NULL AUTO_INCREMENT,
  `nome_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nome_plural_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagem_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '../../css/img/ingrediente/no_image.png',
  `fk_id_categoria_ingrediente` int DEFAULT NULL,
  PRIMARY KEY (`id_ingrediente`),
  UNIQUE KEY `nome_ingrediente` (`nome_ingrediente`,`nome_plural_ingrediente`),
  KEY `fk_categoria_ingrediente` (`fk_id_categoria_ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=7938 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nome_ingrediente`, `nome_plural_ingrediente`, `imagem_ingrediente`, `fk_id_categoria_ingrediente`) VALUES
(1, 'Abacate', 'Abacates', '../../css/img/ingrediente/1.png', 4),
(2, 'Abacaxi', 'Abacaxis', '../../css/img/ingrediente/2.png', 4),
(3, 'Açaí (Fruta)', 'Açaís (Fruta)', '../../css/img/ingrediente/3.png', 4),
(4, 'Banana', 'Bananas', '../../css/img/ingrediente/4.png', 4),
(5, 'Goiaba', '', '../../css/img/ingrediente/5.png', 4),
(6, 'Kiwi', 'Kiwis', '../../css/img/ingrediente/6.png', 4),
(7, 'Laranja', '', '../../css/img/ingrediente/7.png', 4),
(8, 'Limão', '', '../../css/img/ingrediente/8.png', 4),
(9, 'Maçã', 'Maçãs', '../../css/img/ingrediente/9.png', 4),
(10, 'Mamão', '', '../../css/img/ingrediente/10.png', 4),
(12, 'Abiu', '', '../../css/img/ingrediente/12.png', 4),
(13, 'Ameixa', '', '../../css/img/ingrediente/13.png', 4),
(17, 'Abacaxi Pérola', '', '../../css/img/ingrediente/2.png', 4),
(18, 'Abacaxi Havaí', '', '../../css/img/ingrediente/2.png', 4),
(19, 'Ovo', '', '../../css/img/ingrediente/no_image.png', 8),
(21, 'Polpa de Açaí', '', '../../css/img/ingrediente/3.png', 5),
(23, 'Banana Verde', 'Bananas Verde', '../../css/img/ingrediente/4.png', 4),
(24, 'Banana da Terra', 'Bananas da Terra', '../../css/img/ingrediente/4.png', 4),
(25, 'Banana Nanica', 'Bananas Nanica', '../../css/img/ingrediente/4.png', 4),
(26, 'Banana Prata', 'Bananas Prata', '../../css/img/ingrediente/4.png', 4),
(31, 'Kiwi Dourado | Kiwi Amarelo', 'Kiwis Dourado | Kiwis Amarelo', '../../css/img/ingrediente/6.png', 4),
(32, 'Goiaba Branca', '', '../../css/img/ingrediente/5.png', 4),
(33, 'Goiaba Vermelha', '', '../../css/img/ingrediente/5.png', 4),
(34, 'Laranja Lima', '', '../../css/img/ingrediente/7.png', 4),
(35, 'Laranja Pera', '', '../../css/img/ingrediente/7.png', 4),
(36, 'Limão Taiti', '', '../../css/img/ingrediente/8.png', 4),
(38, 'Limão Siciliano', '', '../../css/img/ingrediente/8.png', 4),
(42, 'Maçã Fuji', 'Maçãs Fuji', '../../css/img/ingrediente/9.png', 4),
(43, 'Maçã Gala', 'Maçãs Gala', '../../css/img/ingrediente/9.png', 4),
(44, 'Maçã Granny Smith', 'Maçãs Granny Smith', '../../css/img/ingrediente/9.png', 4),
(45, 'Maçã Red Argentina', 'Maçãs Red Argentina', '../../css/img/ingrediente/9.png', 4),
(46, 'Mamão Formosa', '', '../../css/img/ingrediente/10.png', 4),
(47, 'Mamão Papaya', '', '../../css/img/ingrediente/10.png', 4),
(48, 'Ameixa Sem Caroço', '', '../../css/img/ingrediente/13.png', 4),
(49, 'Polpa de Abacaxi', '', '../../css/img/ingrediente/2.png', 5),
(50, 'Polpa de Abiu', '', '../../css/img/ingrediente/12.png', 5),
(52, 'Ameixa Preta', '', '../../css/img/ingrediente/13.png', 4),
(53, 'Polpa de Ameixa Preta', '', '../../css/img/ingrediente/13.png', 5),
(54, 'Polpa de Ameixa', '', '../../css/img/ingrediente/13.png', 5),
(55, 'Polpa de Banana', 'Polpa de Banana', '../../css/img/ingrediente/4.png', 5),
(56, 'Polpa de Goiaba', '', '../../css/img/ingrediente/5.png', 5),
(58, 'Gelatina em Pó Sabor Algodão Doce', '', '../../css/img/ingrediente/58.jpg', 26),
(59, 'Gelatina em Pó Sabor Amora', '', '../../css/img/ingrediente/no_image.png', 26),
(60, 'Gelatina em Pó Sabor Açaí com Banana', 'Gelatina em Pó Sabor Açaí com Banana', '../../css/img/ingrediente/no_image.png', 26),
(61, 'Gelatina em Pó Sabor Morango', '', '../../css/img/ingrediente/61.jpg', 26),
(62, 'Gelatina em Pó Sabor Uva\n', '', '../../css/img/ingrediente/62.jpg', 26),
(71, 'Gelatina em Pó Sabor Abacaxi', '', '../../css/img/ingrediente/71.jpg', 26),
(72, 'Gelatina em Pó Sabor Cereja', '', '../../css/img/ingrediente/61.jpg', 26),
(75, 'Gelatina em Pó Sabor Tutti-Frutti', '', '../../css/img/ingrediente/75.jpg', 26),
(76, 'Gelatina em Pó Sabor Framboesa', '', '../../css/img/ingrediente/61.jpg', 26),
(77, 'Gelatina em Pó Sabor Limão', '', '../../css/img/ingrediente/77.jpg', 26),
(78, 'Gelatina em Pó Sabor Cereja com Amora Silvestre', '', '../../css/img/ingrediente/no_image.png', 26),
(83, 'Gelatina em Pó Sabor Maracujá', '', '../../css/img/ingrediente/71.jpg', 26),
(84, 'Gelatina em Pó Sabor Pessego', '', '../../css/img/ingrediente/71.jpg', 26),
(87, 'Gelatina Incolor Sem Sabor', '', '../../css/img/ingrediente/87.png', 26),
(88, 'Leite Condensado | Leite Moça', 'Leite Condensado | Leite Moça', '../../css/img/ingrediente/88.png', 8),
(89, 'Creme de Leite', '', '../../css/img/ingrediente/89.png', 8),
(90, 'Leite Condensado | Leite Moça (Sem Lactose)', 'Leite Condensado | Leite Moça (Sem Lactose)', '../../css/img/ingrediente/88.png', 8),
(91, 'Creme de Leite (Sem Lactose)', '', '../../css/img/ingrediente/89.png', 8),
(92, 'Gelatina em Pó (Qualquer Sabor)', '', '../../css/img/ingrediente/92.png', 26),
(94, 'Água', 'Água', '../../css/img/ingrediente/94.png', 28),
(95, 'Água com Gás', 'Água com Gás', '../../css/img/ingrediente/94.png', 28),
(96, 'Água Alcalina', 'Água Alcalina', '../../css/img/ingrediente/94.png', 28),
(97, 'Sal', '', '../../css/img/ingrediente/87.png', 1),
(98, 'Açúcar', 'Açúcar', '../../css/img/ingrediente/87.png', 1),
(101, 'Sal Refinado', '', '../../css/img/ingrediente/87.png', NULL),
(102, 'Sal Marinho', '', '../../css/img/ingrediente/87.png', NULL),
(103, 'Sal do Himalaia', '', '../../css/img/ingrediente/no_image.png', NULL),
(104, 'Pedra de Sal Rosa do Himalaia', '', '../../css/img/ingrediente/87.png', NULL),
(105, 'Flor de Sal', '', '../../css/img/ingrediente/87.png', NULL),
(106, 'Sal Kosher', '', '../../css/img/ingrediente/87.png', NULL),
(107, 'Sal Maldon', '', '../../css/img/ingrediente/87.png', NULL),
(108, 'Sal Light', '', '../../css/img/ingrediente/87.png', NULL),
(109, 'Açúcar Cristal', 'Açúcar Cristal', '../../css/img/ingrediente/87.png', 16),
(110, 'Açúcar Refinado', 'Açúcar Refinado', '../../css/img/ingrediente/87.png', 16),
(111, 'Açúcar Mascavo', 'Açúcar Mascavo', '../../css/img/ingrediente/87.png', 16),
(112, 'Açúcar Demerara', 'Açúcar Demerara', '../../css/img/ingrediente/112.png', 16),
(113, 'Açúcar de Coco', 'Açúcar de Coco', '../../css/img/ingrediente/87.png', 16),
(114, 'Açúcar Light', 'Açúcar Light', '../../css/img/ingrediente/87.png', 16),
(115, 'Flocos de Aveia', '', '../../css/img/ingrediente/no_image.png', 20),
(117, 'Whiskey Teor 100', 'Whiskey Teor 100', '../../css/img/ingrediente/no_image.png', 27),
(118, 'Whiskey Teor 80', 'Whiskey Teor 80', '../../css/img/ingrediente/no_image.png', 27),
(119, 'Whiskey', 'Whiskey', '../../css/img/ingrediente/no_image.png', 27),
(120, 'Whiskey Teor 86', 'Whiskey Teor 86', '../../css/img/ingrediente/no_image.png', 27),
(121, 'Whiskey Teor 90', 'Whiskey Teor 90', '../../css/img/ingrediente/no_image.png', 27),
(122, 'Whiskey Teor 94', 'Whiskey Teor 94', '../../css/img/ingrediente/no_image.png', 27),
(135, 'Vodka Teor 94', '', '../../css/img/ingrediente/no_image.png', 27),
(136, 'Vodka Teor 90', '', '../../css/img/ingrediente/no_image.png', 27),
(137, 'Vodka Teor 80', '', '../../css/img/ingrediente/no_image.png', 27),
(138, 'Vodka Teor 100', '', '../../css/img/ingrediente/no_image.png', 27),
(139, 'Vinho', 'Vinho', '../../css/img/ingrediente/no_image.png', 27),
(140, 'Vinho Tinto', 'Vinho Tinto', '../../css/img/ingrediente/no_image.png', 27),
(141, 'Vinho Rosé', 'VinhoRosé', '../../css/img/ingrediente/no_image.png', 27),
(142, 'Vinho Moscatel', 'Vinho Moscatel', '../../css/img/ingrediente/no_image.png', 27),
(143, 'Vinho de Maçã', 'Vinho de Maçã', '../../css/img/ingrediente/no_image.png', 27),
(144, 'Vinho de Jenipapo', 'Vinho de Jenipapo', '../../css/img/ingrediente/no_image.png', 27),
(145, 'Vinho Branco Seco', 'Vinho Branco Seco', '../../css/img/ingrediente/no_image.png', 27),
(146, 'Vinho Branco Médio', 'Vinho Branco Médio', '../../css/img/ingrediente/no_image.png', 27),
(147, 'Vinho Aperitivo Seco', 'Vinho Aperitivo Seco', '../../css/img/ingrediente/no_image.png', 27),
(148, 'Vinho Aperitivo Doce', 'Vinho Aperitivo Doce', '../../css/img/ingrediente/no_image.png', 27),
(163, 'Arroz', 'Arroz', '../../css/img/ingrediente/no_image.png', 20),
(164, 'Arroz Agulhinha', '', '../../css/img/ingrediente/no_image.png', 20),
(165, 'Arroz Arbóreo', '', '../../css/img/ingrediente/no_image.png', 20),
(167, 'Arroz Basmati', '', '../../css/img/ingrediente/no_image.png', 20),
(168, 'Arroz Branco', '', '../../css/img/ingrediente/no_image.png', 20),
(170, 'Arroz Cateto', '', '../../css/img/ingrediente/no_image.png', 20),
(171, 'Arroz Integral', '', '../../css/img/ingrediente/no_image.png', 20),
(172, 'Arroz Japonês', '', '../../css/img/ingrediente/no_image.png', 20),
(173, 'Arroz Jasmim', '', '../../css/img/ingrediente/no_image.png', 20),
(174, 'Arroz Negro', '', '../../css/img/ingrediente/no_image.png', 20),
(175, 'Arroz Parboilizado', '', '../../css/img/ingrediente/no_image.png', 20),
(176, 'Arroz Selvagem', '', '../../css/img/ingrediente/no_image.png', 20),
(177, 'Arroz Vermelho', '', '../../css/img/ingrediente/no_image.png', 20),
(188, 'Leite', 'Leite', '../../css/img/ingrediente/no_image.png', 8),
(189, 'Azeite', '', '../../css/img/ingrediente/no_image.png', 1),
(190, 'Pimenta-do-reino', '', '../../css/img/ingrediente/no_image.png', 1),
(191, 'Alface', 'Alfaces', '../../css/img/ingrediente/no_image.png', 2),
(192, 'Espinafre', '', '../../css/img/ingrediente/no_image.png', 2),
(193, 'Rúcula', '', '../../css/img/ingrediente/no_image.png', 2),
(194, 'Couve', '', '../../css/img/ingrediente/no_image.png', 2),
(195, 'Brócolis', '', '../../css/img/ingrediente/no_image.png', 2),
(196, 'Cenoura', '', '../../css/img/ingrediente/no_image.png', 2),
(197, 'Batata', '', '../../css/img/ingrediente/no_image.png', 2),
(198, 'Cebola', '', '../../css/img/ingrediente/no_image.png', 2),
(199, 'Alho-poró', 'Alhos-poró', '../../css/img/ingrediente/no_image.png', 2),
(200, 'Champignon', '', '../../css/img/ingrediente/no_image.png', 3),
(201, 'Shitake', '', '../../css/img/ingrediente/no_image.png', 3),
(202, 'Funghi secchi', '', '../../css/img/ingrediente/no_image.png', 3),
(203, 'Geleia de Morango', '', '../../css/img/ingrediente/no_image.png', 5),
(204, 'Geleia de Damasco', '', '../../css/img/ingrediente/no_image.png', 5),
(205, 'Frutas Cristalizadas', '', '../../css/img/ingrediente/no_image.png', 5),
(206, 'Nozes', '', '../../css/img/ingrediente/no_image.png', 6),
(207, 'Amêndoa', 'Amêndoas', '../../css/img/ingrediente/no_image.png', 6),
(208, 'Damasco Seco', '', '../../css/img/ingrediente/no_image.png', 6),
(209, 'Uvas Passas', '', '../../css/img/ingrediente/no_image.png', 6),
(210, 'Queijo Mussarela', '', '../../css/img/ingrediente/no_image.png', 7),
(211, 'Queijo Parmesão', '', '../../css/img/ingrediente/no_image.png', 7),
(212, 'Queijo Gouda', '', '../../css/img/ingrediente/no_image.png', 7),
(213, 'Queijo Brie', '', '../../css/img/ingrediente/no_image.png', 7),
(214, 'Queijo Gorgonzola', '', '../../css/img/ingrediente/no_image.png', 7),
(215, 'Manteiga', '', '../../css/img/ingrediente/no_image.png', 8),
(216, 'Iogurte Natural', '', '../../css/img/ingrediente/no_image.png', 8),
(217, 'Tofu', '', '../../css/img/ingrediente/no_image.png', 9),
(218, 'Proteína de Soja', '', '../../css/img/ingrediente/no_image.png', 9),
(219, 'Leite de Amêndoas', '', '../../css/img/ingrediente/no_image.png', 9),
(220, 'Presunto', '', '../../css/img/ingrediente/no_image.png', 10),
(221, 'Salame', '', '../../css/img/ingrediente/no_image.png', 10),
(222, 'Peito de Peru', '', '../../css/img/ingrediente/no_image.png', 10),
(223, 'Patinho', '', '../../css/img/ingrediente/no_image.png', 11),
(224, 'Alcatra', 'Alcatra', '../../css/img/ingrediente/no_image.png', 11),
(225, 'Filé Mignon', '', '../../css/img/ingrediente/no_image.png', 11),
(226, 'Lombo', '', '../../css/img/ingrediente/no_image.png', 11),
(227, 'Pernil', '', '../../css/img/ingrediente/no_image.png', 11),
(228, 'Peito de Frango', '', '../../css/img/ingrediente/no_image.png', 12),
(229, 'Coxa de Frango', '', '../../css/img/ingrediente/no_image.png', 12),
(230, 'Sobrecoxa de Frango', '', '../../css/img/ingrediente/no_image.png', 12),
(231, 'Salmão', '', '../../css/img/ingrediente/no_image.png', 13),
(232, 'Atum', '', '../../css/img/ingrediente/no_image.png', 13),
(233, 'Bacalhau', '', '../../css/img/ingrediente/no_image.png', 13),
(234, 'Camarão', '', '../../css/img/ingrediente/no_image.png', 14),
(235, 'Lula', '', '../../css/img/ingrediente/no_image.png', 14),
(236, 'Mexilhão', '', '../../css/img/ingrediente/no_image.png', 14),
(237, 'Lagosta', '', '../../css/img/ingrediente/no_image.png', 14),
(238, 'Cúrcuma', '', '../../css/img/ingrediente/no_image.png', 15),
(239, 'Cominho', '', '../../css/img/ingrediente/no_image.png', 15),
(240, 'Coentro', '', '../../css/img/ingrediente/no_image.png', 15),
(241, 'Páprica', '', '../../css/img/ingrediente/no_image.png', 15),
(242, 'Gengibre', '', '../../css/img/ingrediente/no_image.png', 15),
(243, 'Mel', '', '../../css/img/ingrediente/no_image.png', 16),
(244, 'Adoçante', 'Adoçante', '../../css/img/ingrediente/no_image.png', 16),
(245, 'Xarope de Bordo', 'Xarope de Bordo', '../../css/img/ingrediente/no_image.png', 16),
(246, 'Pimenta Jalapeño', '', '../../css/img/ingrediente/no_image.png', 17),
(247, 'Pimenta Dedo-de-moça', '', '../../css/img/ingrediente/no_image.png', 17),
(248, 'Pimenta Malagueta', '', '../../css/img/ingrediente/no_image.png', 17),
(249, 'Capuchinha', '', '../../css/img/ingrediente/no_image.png', 18),
(250, 'Flor de Hibisco', '', '../../css/img/ingrediente/no_image.png', 18),
(251, 'Lavanda', '', '../../css/img/ingrediente/no_image.png', 18),
(252, 'Farinha de Trigo', '', '../../css/img/ingrediente/no_image.png', 19),
(253, 'Fermento Químico', '', '../../css/img/ingrediente/no_image.png', 19),
(254, 'Farinha de Rosca', '', '../../css/img/ingrediente/no_image.png', 19),
(255, 'Fermento Biológico', '', '../../css/img/ingrediente/no_image.png', 19),
(256, 'Feijão', '', '../../css/img/ingrediente/no_image.png', 20),
(257, 'Lentilha', '', '../../css/img/ingrediente/no_image.png', 20),
(258, 'Quinoa', '', '../../css/img/ingrediente/no_image.png', 20),
(259, 'Semente de Girassol', 'Sementes de Girassol', '../../css/img/ingrediente/no_image.png', 20),
(260, 'Linhaça', '', '../../css/img/ingrediente/no_image.png', 20),
(261, 'Macarrão Espaguete', '', '../../css/img/ingrediente/no_image.png', 21),
(262, 'Macarrão Penne', '', '../../css/img/ingrediente/no_image.png', 21),
(263, 'Macarrão (Em Geral)', '', '../../css/img/ingrediente/no_image.png', 21),
(264, 'Talharim', '', '../../css/img/ingrediente/no_image.png', 21),
(265, 'Óleo de Girassol', '', '../../css/img/ingrediente/no_image.png', 22),
(266, 'Azeite de Oliva', '', '../../css/img/ingrediente/no_image.png', 22),
(267, 'Vinagre Balsâmico', '', '../../css/img/ingrediente/no_image.png', 22),
(268, 'Vinagre de Maçã', 'Vinagre de Maçã', '../../css/img/ingrediente/no_image.png', 22),
(269, 'Banha de Porco', '', '../../css/img/ingrediente/no_image.png', 22),
(270, 'Milho em Conserva', '', '../../css/img/ingrediente/no_image.png', 23),
(271, 'Pepino em Conserva', '', '../../css/img/ingrediente/no_image.png', 23),
(272, 'Azeitona', '', '../../css/img/ingrediente/no_image.png', 23),
(273, 'Palmito', '', '../../css/img/ingrediente/no_image.png', 23),
(274, 'Molho de Tomate', '', '../../css/img/ingrediente/no_image.png', 24),
(275, 'Ketchup', '', '../../css/img/ingrediente/no_image.png', 24),
(276, 'Mostarda', '', '../../css/img/ingrediente/no_image.png', 24),
(277, 'Maionese', '', '../../css/img/ingrediente/no_image.png', 24),
(278, 'Molho de Soja | Molho Shoyu', 'Molho de Soja | Molho Shoyu', '../../css/img/ingrediente/no_image.png', 24),
(279, 'Caldo de Legumes', '', '../../css/img/ingrediente/no_image.png', 25),
(280, 'Caldo de Galinha', '', '../../css/img/ingrediente/no_image.png', 25),
(281, 'Caldo de Carde', '', '../../css/img/ingrediente/no_image.png', 25),
(282, 'Sopa de Cebola', '', '../../css/img/ingrediente/no_image.png', 25),
(283, 'Chocolate', '', '../../css/img/ingrediente/no_image.png', 26),
(284, 'Biscoitos', '', '../../css/img/ingrediente/no_image.png', 26),
(285, 'Pipoca de Microondas', '', '../../css/img/ingrediente/no_image.png', 26),
(287, 'Pipoca de Microondas Sabor Manteiga', '', '../../css/img/ingrediente/no_image.png', 26),
(288, 'Pão Francês', 'Pães Franceses', '../../css/img/ingrediente/no_image.png', 29),
(289, 'Pão de Forma', 'Pães de Forma', '../../css/img/ingrediente/no_image.png', 29),
(290, 'Croissant', '', '../../css/img/ingrediente/no_image.png', 29),
(291, 'Pão Integral', 'Pães Integral', '../../css/img/ingrediente/no_image.png', 29),
(292, 'Manteiga de Cacau', 'Manteiga de Cacau', '../../css/img/ingrediente/no_image.png', 26),
(314, 'Tomate', 'Tomates', '../../css/img/ingrediente/no_image.png', 2),
(315, 'Broto de Feijão', 'Brotos de Feijão', '../../css/img/ingrediente/no_image.png', 2),
(316, 'Castanha de Caju', 'Castanhas de Caju', '../../css/img/ingrediente/no_image.png', 2),
(317, 'Couve de Bruxelas', 'Couves de Bruxelas', '../../css/img/ingrediente/no_image.png', 2),
(318, 'Couve-Flor', 'Couves-Flores', '../../css/img/ingrediente/no_image.png', 2),
(319, 'Couve-Manteiga', 'Couves-Manteigas', '../../css/img/ingrediente/no_image.png', 2),
(320, 'Damasco Seco', 'Damascos Secos', '../../css/img/ingrediente/no_image.png', 2),
(321, 'Fisalis', 'Fisalis', '../../css/img/ingrediente/no_image.png', 2),
(322, 'Pepino Japonês', 'Pepinos Japoneses', '../../css/img/ingrediente/no_image.png', 2),
(323, 'Raíz Forte', 'Raízes Fortes', '../../css/img/ingrediente/no_image.png', 2),
(324, 'Abóbora Manteiga', 'Abóboras Manteigas', '../../css/img/ingrediente/no_image.png', 2),
(325, 'Abóbora Moranga', 'Abóboras Morangas', '../../css/img/ingrediente/no_image.png', 2),
(326, 'Abóbora Seca', 'Abóboras Secas', '../../css/img/ingrediente/no_image.png', 6),
(327, 'Abobrinha', 'Abobrinhas', '../../css/img/ingrediente/no_image.png', 2),
(328, 'Acelga', 'Acelgas', '../../css/img/ingrediente/no_image.png', 2),
(329, 'Agrião', 'Agriões', '../../css/img/ingrediente/no_image.png', 2),
(330, 'Aipo-Rábano', 'Aipos-Rábanos', '../../css/img/ingrediente/no_image.png', 2),
(331, 'Alcachofra', 'Alcachofras', '../../css/img/ingrediente/no_image.png', 2),
(332, 'Alcachofra de Jerusalém', 'Alcachofras de Jerusalém', '../../css/img/ingrediente/no_image.png', 2),
(333, 'Alface Americana', 'Alfaces Americanas', '../../css/img/ingrediente/no_image.png', 2),
(334, 'Alface Manteiga', 'Alfaces Manteigas', '../../css/img/ingrediente/no_image.png', 2),
(335, 'Alface-Romana', 'Alfaces-Romanas', '../../css/img/ingrediente/no_image.png', 2),
(336, 'Alfafa', 'Alfafas', '../../css/img/ingrediente/no_image.png', 2),
(337, 'Dente de Alho', 'Dentes de Alho', '../../css/img/ingrediente/no_image.png', 2),
(338, 'Alho Negro', 'Alhos Negros', '../../css/img/ingrediente/no_image.png', 2),
(339, 'Almeirão', 'Almeirões', '../../css/img/ingrediente/no_image.png', 2),
(340, 'Ameixa Seca', 'Ameixas Secas', '../../css/img/ingrediente/13.png', 6),
(341, 'Amendoim', 'Amendoins', '../../css/img/ingrediente/no_image.png', 2),
(342, 'Aspargo', 'Aspargos', '../../css/img/ingrediente/no_image.png', 2),
(343, 'Avelã', 'Avelãs', '../../css/img/ingrediente/no_image.png', 2),
(344, 'Azedinha', 'Azedinhas', '../../css/img/ingrediente/no_image.png', 2),
(345, 'Bardana', 'Bardanas', '../../css/img/ingrediente/no_image.png', 2),
(346, 'Batata Doce', 'Batatas Doces', '../../css/img/ingrediente/no_image.png', 2),
(347, 'Batata Nova', 'Batatas Novas', '../../css/img/ingrediente/no_image.png', 2),
(348, 'Bertalha', 'Bertalhas', '../../css/img/ingrediente/no_image.png', 2),
(349, 'Beterraba', 'Beterrabas', '../../css/img/ingrediente/no_image.png', 2),
(350, 'Acelga Chinesa | Bok Choy', 'Acelgas Chinesas | Bok Choys', '../../css/img/ingrediente/no_image.png', 2),
(351, 'Brócolis Rabe', 'Brócolis Rabes', '../../css/img/ingrediente/no_image.png', 2),
(352, 'Broto de Alfafa', 'Brotos de Alfafa', '../../css/img/ingrediente/no_image.png', 2),
(353, 'Broto de Bambu', 'Brotos de Bambu', '../../css/img/ingrediente/no_image.png', 2),
(354, 'Cabaça', 'Cabaças', '../../css/img/ingrediente/no_image.png', 2),
(355, 'Cabotiá', 'Cabotiás', '../../css/img/ingrediente/no_image.png', 2),
(356, 'Cará', 'Carás', '../../css/img/ingrediente/no_image.png', 2),
(357, 'Carqueja', 'Carquejas', '../../css/img/ingrediente/no_image.png', 2),
(358, 'Castanha do Pará', 'Castanhas do Pará', '../../css/img/ingrediente/no_image.png', 2),
(359, 'Castanha Portuguesa', 'Castanhas Portuguesas', '../../css/img/ingrediente/no_image.png', 2),
(360, 'Castanha d\'Água', 'Castanhas d\'Água', '../../css/img/ingrediente/no_image.png', 2),
(361, 'Cebola Pera', 'Cebolas Pera', '../../css/img/ingrediente/no_image.png', 2),
(362, 'Cebola Roxa', 'Cebolas Roxas', '../../css/img/ingrediente/no_image.png', 2),
(363, 'Cebola Vermelha', 'Cebolas Vermelhas', '../../css/img/ingrediente/no_image.png', 2),
(364, 'Cerefólio', 'Cerefólios', '../../css/img/ingrediente/no_image.png', 2),
(365, 'Chalota', 'Chalotas', '../../css/img/ingrediente/no_image.png', 2),
(366, 'Chicória', 'Chicórias', '../../css/img/ingrediente/no_image.png', 2),
(367, 'Chuchu', 'Chuchus', '../../css/img/ingrediente/no_image.png', 2),
(368, 'Coco Ralado', 'Cocos Ralados', '../../css/img/ingrediente/no_image.png', 2),
(369, 'Couve Coração-de-Boi', 'Couves Coração-de-Boi', '../../css/img/ingrediente/no_image.png', 2),
(370, 'Couve Roxa', 'Couves Roxas', '../../css/img/ingrediente/no_image.png', 2),
(371, 'Escarola', 'Escarolas', '../../css/img/ingrediente/no_image.png', 2),
(372, 'Galanga', 'Galangas', '../../css/img/ingrediente/no_image.png', 2),
(373, 'Grelos', 'Grelos', '../../css/img/ingrediente/no_image.png', 2),
(374, 'Grelos de Couve', 'Grelos de Couves', '../../css/img/ingrediente/no_image.png', 2),
(375, 'Grelos de Nabo', 'Grelos de Nabos', '../../css/img/ingrediente/no_image.png', 2),
(376, 'Inhame', 'Inhames', '../../css/img/ingrediente/no_image.png', 2),
(377, 'Jambú', 'Jambús', '../../css/img/ingrediente/no_image.png', 2),
(378, 'Jiló', 'Jilós', '../../css/img/ingrediente/no_image.png', 2),
(379, 'Legumes Chineses', 'Legumes Chineses', '../../css/img/ingrediente/no_image.png', 2),
(380, 'Mandioca', 'Mandiocas', '../../css/img/ingrediente/no_image.png', 2),
(381, 'Mandioquinha', 'Mandioquinhas', '../../css/img/ingrediente/no_image.png', 2),
(382, 'Maniva', 'Manivas', '../../css/img/ingrediente/no_image.png', 2),
(383, 'Maxixe', 'Maxixes', '../../css/img/ingrediente/no_image.png', 2),
(384, 'Milho Verde', 'Milhos Verdes', '../../css/img/ingrediente/no_image.png', 2),
(385, 'Mini Cebolas', 'Mini Cebolas', '../../css/img/ingrediente/no_image.png', 2),
(386, 'Mix de Folhas Verdes', 'Mix de Folhas Verdes', '../../css/img/ingrediente/no_image.png', 2),
(387, 'Mix de Legumes', 'Mix de Legumes', '../../css/img/ingrediente/no_image.png', 2),
(388, 'Nabo', 'Nabos', '../../css/img/ingrediente/no_image.png', 2),
(389, 'Nirá', 'Nirás', '../../css/img/ingrediente/no_image.png', 2),
(390, 'Ora-Pro-Nóbis (Folha)', 'Ora-Pro-Nóbis (Folhas)', '../../css/img/ingrediente/no_image.png', 2),
(391, 'Passas', 'Passas', '../../css/img/ingrediente/no_image.png', 2),
(392, 'Pimenta Cambuci', 'Pimentas Cambuci', '../../css/img/ingrediente/no_image.png', 2),
(393, 'Óleo de Cozinha', 'Óleo de Cozinha', '../../css/img/ingrediente/no_image.png', NULL),
(394, 'Vinagre', 'Vinagre', '../../css/img/ingrediente/no_image.png', 22),
(395, 'Orégano', 'Orégano', '../../css/img/ingrediente/no_image.png', NULL),
(396, 'Gelo', 'Gelo', '../../css/img/ingrediente/no_image.png', NULL),
(397, 'Xarope de Fruta (Qualquer Sabor)', '', '../../css/img/ingrediente/no_image.png', 26),
(398, 'Chantilly', '', '../../css/img/ingrediente/no_image.png', NULL),
(399, 'Pistache', 'Pistache', '../../css/img/ingrediente/no_image.png', NULL),
(400, 'Pistache Triturado', 'Pistache Triturado', '../../css/img/ingrediente/no_image.png', NULL),
(401, 'Pasta de Pistache', 'Pasta de Pistache', '../../css/img/ingrediente/no_image.png', NULL),
(402, 'Glucose de Milho', 'Glucose de Milho', '../../css/img/ingrediente/no_image.png', NULL),
(403, 'Ora-Pro-Nóbis (Flor)', 'Ora-Pro-Nóbis (Flores)', '../../css/img/ingrediente/no_image.png', 2),
(404, 'Ora-Pro-Nóbis (Fruto)', 'Ora-Pro-Nóbis (Frutos)', '../../css/img/ingrediente/no_image.png', 2),
(405, 'Pó para Preparo de Sobremesa Sabor Morango', 'Pó para Preparo de Sobremesa Sabor Morango', '../../css/img/ingrediente/no_image.png', 26),
(406, 'Pó para Preparo de Sobremesa Sabor Limão', 'Pó para Preparo de Sobremesa Sabor Limão', '../../css/img/ingrediente/no_image.png', 26),
(407, 'Pó para Preparo de Sobremesa Sabor Maracujá', 'Pó para Preparo de Sobremesa Sabor Maracujá', '../../css/img/ingrediente/no_image.png', 26),
(408, 'Leite em Pó | Leite Ninho', 'Leite em Pó | Leite Ninho', '../../css/img/ingrediente/no_image.png', 26),
(409, 'Chocolate Branco', 'Chocolate Branco', '../../css/img/ingrediente/no_image.png', 26),
(410, 'Goiabada', 'Goiabada', '../../css/img/ingrediente/no_image.png', NULL),
(411, 'Cobertura Sabor Chocolate Branco em Barra', 'Cobertura Sabor Chocolate Branco em Barra', '../../css/img/ingrediente/no_image.png', 26),
(412, 'Cobertura Sabor Chocolate em Barra', 'Cobertura Sabor Chocolate em Barra', '../../css/img/ingrediente/no_image.png', 26),
(413, 'Danoninho | Queijo Petit Suisse Sabor Morango', 'Danoninho | Queijo Petit Suisse Sabor Morango', '../../css/img/ingrediente/no_image.png', NULL),
(414, 'Danoninho Sabor Morango, Banana e Maçã Verde | Queijo Petit Suisse Sabor Morango, Banana e Maçã Verde', 'Danoninho Sabor Morango, Banana e Maçã Verde | Queijo Petit Suisse Sabor Morango, Banana e Maçã Verde', '../../css/img/ingrediente/no_image.png', NULL),
(415, 'Danoninho Sabor Morango e Banana | Queijo Petit Suisse Sabor Morango, Banana e Maçã Verde', 'Danoninho Sabor Morango e Banana | Queijo Petit Suisse Sabor Morango, Banana e Maçã Verde', '../../css/img/ingrediente/no_image.png', NULL),
(416, 'Iogurte Líquido Danoninho Morango', 'Iogurte Líquido Danoninho Morango', '../../css/img/ingrediente/no_image.png', NULL),
(417, 'Iogurte Líquido Danoninho Banana e Maçã\r\n', 'Iogurte Líquido Danoninho Banana e Maçã', '../../css/img/ingrediente/no_image.png', NULL),
(418, 'Iogurte Líquido Danoninho Banana e Maçã', 'Iogurte Líquido Danoninho Banana e Maçã', '../../css/img/ingrediente/no_image.png', NULL),
(419, 'Arroz para Sushi', 'Arroz para Sushi', '../../css/img/ingrediente/no_image.png', NULL),
(420, 'Kani', 'Kanis', '../../css/img/ingrediente/no_image.png', NULL),
(421, 'Manga', 'Mangas', '../../css/img/ingrediente/no_image.png', 4),
(422, 'Pepino', 'Pepinos', '../../css/img/ingrediente/no_image.png', 2),
(423, 'Vinagre de Arroz', 'Vinagre de Arroz', '../../css/img/ingrediente/no_image.png', NULL),
(424, 'Farinha Panko', 'Farinha Panko', '../../css/img/ingrediente/no_image.png', NULL),
(425, 'Folha de Nori', 'Folhas de Nori', '../../css/img/ingrediente/no_image.png', NULL),
(426, 'Chocolate ao Leite', 'Chocolate ao Leite', '../../css/img/ingrediente/no_image.png', NULL),
(427, 'Dente de Cravo', 'Dentes de Cravo', '../../css/img/ingrediente/no_image.png', NULL),
(428, 'Leite (sem lactose)', 'Leite (sem lactose)', '../../css/img/ingrediente/no_image.png', 8),
(429, 'Abacaxi Seco', 'Abacaxis Secos', '../../css/img/ingrediente/no_image.png', 6),
(430, 'Banana Seca', 'Bananas Secas', '../../css/img/ingrediente/no_image.png', 6),
(431, 'Cranberrie Seca', 'Cranberries Secas', '../../css/img/ingrediente/no_image.png', 6),
(432, 'Figo Seco', 'Figos Secos', '../../css/img/ingrediente/no_image.png', 6),
(433, 'Framboesa Seca', 'Framboesas Secas', '../../css/img/ingrediente/no_image.png', 6),
(434, 'Goji Berry', 'Gojis Berries', '../../css/img/ingrediente/no_image.png', 6),
(435, 'Laranja Seca', 'Laranjas Secas', '../../css/img/ingrediente/no_image.png', 6),
(436, 'Frutas Secas', '', '../../css/img/ingrediente/no_image.png', 6),
(437, 'Asiago', '', '../../css/img/ingrediente/no_image.png', 7),
(438, 'Boursin', '', '../../css/img/ingrediente/no_image.png', 7),
(439, 'Brie', '', '../../css/img/ingrediente/no_image.png', 7),
(440, 'Camembert', '', '../../css/img/ingrediente/no_image.png', 7),
(441, 'Catupiry', '', '../../css/img/ingrediente/no_image.png', 7),
(442, 'Almôndegas de Frango', '', '../../css/img/ingrediente/no_image.png', 12),
(443, 'Asa de Frango', '', '../../css/img/ingrediente/no_image.png', 12),
(444, 'Asa de Peru', '', '../../css/img/ingrediente/no_image.png', 12),
(445, 'Açúcar de Coco', '', '../../css/img/ingrediente/no_image.png', 16),
(446, 'Água de Rosas', '', '../../css/img/ingrediente/no_image.png', 16),
(447, 'Essência de Morango', '', '../../css/img/ingrediente/no_image.png', 16),
(448, 'Amaranto', '', '../../css/img/ingrediente/no_image.png', 20),
(449, 'Arroz', '', '../../css/img/ingrediente/no_image.png', 20),
(450, 'Aveia', '', '../../css/img/ingrediente/no_image.png', 20),
(451, 'Absinto', '', '../../css/img/ingrediente/no_image.png', 27),
(452, 'Aperol', '', '../../css/img/ingrediente/no_image.png', 27),
(453, 'Cachaça', '', '../../css/img/ingrediente/no_image.png', 27),
(454, 'Bagel', '', '../../css/img/ingrediente/no_image.png', 29),
(455, 'Baguete', '', '../../css/img/ingrediente/no_image.png', 29),
(456, 'Biscoito Amanteigado', 'Biscoitos Amanteigados', '../../css/img/ingrediente/no_image.png', 29),
(510, 'Café Coado', 'Cafés Coados', '../../css/img/ingrediente/no_image.png', NULL),
(511, 'Abóbora', 'Abóboras', '../../css/img/ingrediente/no_image.png', NULL),
(513, 'Abricó', 'Abricós', '../../css/img/ingrediente/no_image.png', NULL),
(514, 'Abrunho', 'Abrunhos', '../../css/img/ingrediente/no_image.png', NULL),
(515, 'Açafrão', 'Açafrões', '../../css/img/ingrediente/no_image.png', NULL),
(516, 'Açafrão Nacional', 'Açafrões Nacionais', '../../css/img/ingrediente/no_image.png', NULL),
(517, 'Acelga-chinesa', 'Acelgas-chinesas', '../../css/img/ingrediente/no_image.png', NULL),
(518, 'Acém', 'Acéns', '../../css/img/ingrediente/no_image.png', NULL),
(519, 'Acerola', 'Acerolas', '../../css/img/ingrediente/no_image.png', NULL),
(520, 'Achocolatado em Pó', 'Achocolatados em Pó', '../../css/img/ingrediente/no_image.png', NULL),
(521, 'Açúcar de Beterraba', 'Açúcares de Beterraba', '../../css/img/ingrediente/no_image.png', NULL),
(522, 'Adoçante', 'Adoçantes', '../../css/img/ingrediente/no_image.png', NULL),
(523, 'Agave-caribenho', 'Agaves-caribenhos', '../../css/img/ingrediente/no_image.png', NULL),
(524, 'Agrião-do-líbano', 'Agriões-do-líbano', '../../css/img/ingrediente/no_image.png', NULL),
(525, 'Água', 'Águas', '../../css/img/ingrediente/no_image.png', NULL),
(526, 'Água com Gás', 'Águas com Gás', '../../css/img/ingrediente/no_image.png', NULL),
(527, 'Água de Coco', 'Águas de Coco', '../../css/img/ingrediente/no_image.png', NULL),
(528, 'Água Tônica', 'Águas Tônicas', '../../css/img/ingrediente/no_image.png', NULL),
(529, 'Aguardente', 'Aguardentes', '../../css/img/ingrediente/no_image.png', NULL),
(530, 'Aipim', 'Aipins', '../../css/img/ingrediente/no_image.png', NULL),
(531, 'Aipo', 'Aipos', '../../css/img/ingrediente/no_image.png', NULL),
(532, 'Akee', 'Akees', '../../css/img/ingrediente/no_image.png', NULL),
(533, 'Alcaparra', 'Alcaparras', '../../css/img/ingrediente/no_image.png', NULL),
(534, 'Alecrim', 'Alecrins', '../../css/img/ingrediente/no_image.png', NULL),
(535, 'Alface-americana', 'Alfaces-americanas', '../../css/img/ingrediente/no_image.png', NULL),
(536, 'Alface-crespa', 'Alfaces-crespas', '../../css/img/ingrediente/no_image.png', NULL),
(537, 'Alface-repolhuda', 'Alfaces-repolhudas', '../../css/img/ingrediente/no_image.png', NULL),
(538, 'Alfafa (broto)', 'Alfafas (brotos)', '../../css/img/ingrediente/no_image.png', NULL),
(539, 'Alfarroba', 'Alfarrobas', '../../css/img/ingrediente/no_image.png', NULL),
(540, 'Alfavaca', 'Alfavacas', '../../css/img/ingrediente/no_image.png', NULL),
(541, 'Amaranto', 'Amarantos', '../../css/img/ingrediente/no_image.png', NULL),
(542, 'Amêndoa (Não Torrada)', 'Amêndoas (Não Torradas)', '../../css/img/ingrediente/no_image.png', NULL),
(543, 'Amêndoa (Torrada)', 'Amêndoas (Torradas)', '../../css/img/ingrediente/no_image.png', NULL),
(544, 'Amêndoas', 'Amêndoas', '../../css/img/ingrediente/no_image.png', NULL),
(545, 'Amendoim-da-mata', 'Amendoins-da-mata', '../../css/img/ingrediente/no_image.png', NULL),
(546, 'Amora', 'Amoras', '../../css/img/ingrediente/no_image.png', NULL),
(547, 'Ananás', 'Ananases', '../../css/img/ingrediente/no_image.png', NULL),
(548, 'Anchova', 'Anchovas', '../../css/img/ingrediente/no_image.png', NULL),
(549, 'Andu', 'Andus', '../../css/img/ingrediente/no_image.png', NULL),
(550, 'Anona', 'Anonas', '../../css/img/ingrediente/no_image.png', NULL),
(551, 'Araçá', 'Araçás', '../../css/img/ingrediente/no_image.png', NULL),
(552, 'Arachachá', 'Arachachás', '../../css/img/ingrediente/no_image.png', NULL),
(553, 'Arando', 'Arandos', '../../css/img/ingrediente/no_image.png', NULL),
(554, 'Araruta', 'Ararutas', '../../css/img/ingrediente/no_image.png', NULL),
(555, 'Araticum', 'Araticuns', '../../css/img/ingrediente/no_image.png', NULL),
(556, 'Asiago', 'Asiagos', '../../css/img/ingrediente/no_image.png', NULL),
(557, 'Ata', 'Atas', '../../css/img/ingrediente/no_image.png', NULL),
(558, 'Atemoia', 'Atemoias', '../../css/img/ingrediente/no_image.png', NULL),
(559, 'Atum', 'Atuns', '../../css/img/ingrediente/no_image.png', NULL),
(560, 'Aveia', 'Aveias', '../../css/img/ingrediente/no_image.png', NULL),
(561, 'Azeite', 'Azeites', '../../css/img/ingrediente/no_image.png', NULL),
(4067, 'Creme de leite com Soro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4068, 'Creme de leite sem Soro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4069, 'Creme de leite com Amido', '', '../../css/img/ingrediente/no_image.png', NULL),
(4070, 'Creme de leite condensado', '', '../../css/img/ingrediente/no_image.png', NULL),
(4071, 'Creme de leite frescobem', '', '../../css/img/ingrediente/no_image.png', NULL),
(4072, 'Creme de leite (sem soro)', '', '../../css/img/ingrediente/no_image.png', NULL),
(4073, 'corante Amarelo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4074, 'corante Azul', '', '../../css/img/ingrediente/no_image.png', NULL),
(4075, 'corante em gel Amarelo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4076, 'corante em gel Azul', '', '../../css/img/ingrediente/no_image.png', NULL),
(4077, 'corante em gel laranja', '', '../../css/img/ingrediente/no_image.png', NULL),
(4078, 'corante em gel Marrom', '', '../../css/img/ingrediente/no_image.png', NULL),
(4079, 'corante em gel ouro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4080, 'corante em gel prata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4081, 'corante em gel preto', '', '../../css/img/ingrediente/no_image.png', NULL),
(4082, 'corante em gel Rosa', '', '../../css/img/ingrediente/no_image.png', NULL),
(4083, 'corante em gel Roxo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4084, 'corante em gel verde', '', '../../css/img/ingrediente/no_image.png', NULL),
(4085, 'corante em gel vermelho', '', '../../css/img/ingrediente/no_image.png', NULL),
(4086, 'corante em pó Amarelo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4087, 'corante em pó Azul', '', '../../css/img/ingrediente/no_image.png', NULL),
(4088, 'corante em pó laranja', '', '../../css/img/ingrediente/no_image.png', NULL),
(4089, 'corante em pó Marrom', '', '../../css/img/ingrediente/no_image.png', NULL),
(4090, 'corante em pó ouro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4091, 'corante em pó prata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4092, 'corante em pó preto', '', '../../css/img/ingrediente/no_image.png', NULL),
(4093, 'corante em pó Rosa', '', '../../css/img/ingrediente/no_image.png', NULL),
(4094, 'corante em pó Roxo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4095, 'corante em pó verde', '', '../../css/img/ingrediente/no_image.png', NULL),
(4096, 'corante em pó vermelho', '', '../../css/img/ingrediente/no_image.png', NULL),
(4097, 'corante em spray Amarelo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4098, 'corante em spray Azul', '', '../../css/img/ingrediente/no_image.png', NULL),
(4099, 'corante em spray laranja', '', '../../css/img/ingrediente/no_image.png', NULL),
(4100, 'corante em spray Marrom', '', '../../css/img/ingrediente/no_image.png', NULL),
(4101, 'corante em spray ouro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4102, 'corante em spray prata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4103, 'corante em spray preto', '', '../../css/img/ingrediente/no_image.png', NULL),
(4104, 'corante em spray Rosa', '', '../../css/img/ingrediente/no_image.png', NULL),
(4105, 'corante em spray Roxo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4106, 'corante em spray verde', '', '../../css/img/ingrediente/no_image.png', NULL),
(4107, 'corante em spray vermelho', '', '../../css/img/ingrediente/no_image.png', NULL),
(4108, 'corante laranja', '', '../../css/img/ingrediente/no_image.png', NULL),
(4109, 'corante líquido Amarelo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4110, 'corante líquido Azul', '', '../../css/img/ingrediente/no_image.png', NULL),
(4111, 'corante líquido laranja', '', '../../css/img/ingrediente/no_image.png', NULL),
(4112, 'corante líquido Marrom', '', '../../css/img/ingrediente/no_image.png', NULL),
(4113, 'corante líquido ouro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4114, 'corante líquido prata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4115, 'corante líquido preto', '', '../../css/img/ingrediente/no_image.png', NULL),
(4116, 'corante líquido Rosa', '', '../../css/img/ingrediente/no_image.png', NULL),
(4117, 'corante líquido Roxo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4118, 'corante líquido verde', '', '../../css/img/ingrediente/no_image.png', NULL),
(4119, 'corante líquido vermelho', '', '../../css/img/ingrediente/no_image.png', NULL),
(4120, 'corante Marrom', '', '../../css/img/ingrediente/no_image.png', NULL),
(4121, 'corante ouro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4122, 'corante prata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4123, 'corante preto', '', '../../css/img/ingrediente/no_image.png', NULL),
(4124, 'corante Rosa', '', '../../css/img/ingrediente/no_image.png', NULL),
(4125, 'corante Roxo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4126, 'corante verde', '', '../../css/img/ingrediente/no_image.png', NULL),
(4127, 'corante vermelho', '', '../../css/img/ingrediente/no_image.png', NULL),
(4137, 'Cravo-da-Índia', '', '../../css/img/ingrediente/no_image.png', NULL),
(4138, 'Cream Cheese', '', '../../css/img/ingrediente/no_image.png', NULL),
(4139, 'Creme Azedo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4140, 'Creme de Café', '', '../../css/img/ingrediente/no_image.png', NULL),
(4141, 'Creme de Menta, teor alcoólico', '', '../../css/img/ingrediente/no_image.png', NULL),
(4142, 'Creme de leite fresco', '', '../../css/img/ingrediente/no_image.png', NULL),
(4143, 'Creme de leite em Lata', '', '../../css/img/ingrediente/no_image.png', NULL),
(4144, 'Creme de leite UHT', '', '../../css/img/ingrediente/no_image.png', NULL),
(4160, 'Couve-de-saboia', '', '../../css/img/ingrediente/no_image.png', NULL),
(4161, 'Couve-flor', '', '../../css/img/ingrediente/no_image.png', NULL),
(4162, 'Couve-lombarda', '', '../../css/img/ingrediente/no_image.png', NULL),
(4163, 'Couve-Mateiga', '', '../../css/img/ingrediente/no_image.png', NULL),
(4164, 'Couve-nabo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4165, 'Couve-nabo (folha)', '', '../../css/img/ingrediente/no_image.png', NULL),
(4166, 'Couve-rábano', '', '../../css/img/ingrediente/no_image.png', NULL),
(4167, 'Couvinha', '', '../../css/img/ingrediente/no_image.png', NULL),
(4168, 'Coxão Duro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4169, 'Coxão mole', '', '../../css/img/ingrediente/no_image.png', NULL),
(4170, 'Coxão-duro', '', '../../css/img/ingrediente/no_image.png', NULL),
(4171, 'Coxão-duro (Bovino)', '', '../../css/img/ingrediente/no_image.png', NULL),
(4172, 'Cranberries Secas', '', '../../css/img/ingrediente/no_image.png', NULL),
(4173, 'Cranberry', '', '../../css/img/ingrediente/no_image.png', NULL),
(4200, 'Ciriguela', '', '../../css/img/ingrediente/no_image.png', NULL),
(4201, 'Ciruela', '', '../../css/img/ingrediente/no_image.png', NULL),
(4202, 'Clara de Ovo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4203, 'Clementina', '', '../../css/img/ingrediente/no_image.png', NULL),
(4204, 'Coalhada', '', '../../css/img/ingrediente/no_image.png', NULL),
(4205, 'Coca Cola', '', '../../css/img/ingrediente/no_image.png', NULL),
(4206, 'Coco', '', '../../css/img/ingrediente/no_image.png', NULL),
(4207, 'Cogumelos', '', '../../css/img/ingrediente/no_image.png', NULL),
(4208, 'Cogumelos Fresco', '', '../../css/img/ingrediente/no_image.png', NULL),
(4209, 'Colorau', '', '../../css/img/ingrediente/no_image.png', NULL),
(4210, 'Comelina', '', '../../css/img/ingrediente/no_image.png', NULL),
(4211, 'Compota de Abobora', '', '../../css/img/ingrediente/no_image.png', NULL),
(4212, 'Compota de Maçã', '', '../../css/img/ingrediente/no_image.png', NULL),
(4213, 'Conhaque', '', '../../css/img/ingrediente/no_image.png', NULL),
(4214, 'Contrafilé', '', '../../css/img/ingrediente/no_image.png', NULL),
(4215, 'Copa Lombo', '', '../../css/img/ingrediente/no_image.png', NULL),
(4216, 'Copa Lombo (Suíno)', '', '../../css/img/ingrediente/no_image.png', NULL),
(4217, 'Coquetel de xs', '', '../../css/img/ingrediente/no_image.png', NULL),
(4218, 'Coração de Bananeira', '', '../../css/img/ingrediente/no_image.png', NULL),
(4739, 'Chaya', '', '../../css/img/ingrediente/no_image.png', NULL),
(4740, 'Chèvre', '', '../../css/img/ingrediente/no_image.png', NULL),
(4741, 'Chia', '', '../../css/img/ingrediente/no_image.png', NULL),
(4742, 'Chichá', '', '../../css/img/ingrediente/no_image.png', NULL),
(4743, 'Chichá-do-norte', '', '../../css/img/ingrediente/no_image.png', NULL),
(4744, 'Chocolate em Pó', '', '../../css/img/ingrediente/no_image.png', NULL),
(4745, 'Chuleta', '', '../../css/img/ingrediente/no_image.png', NULL),
(4746, 'Ciabatta', '', '../../css/img/ingrediente/no_image.png', NULL),
(4747, 'Cidra', '', '../../css/img/ingrediente/no_image.png', NULL),
(6571, 'Celósia (sementes)', '', '../../css/img/ingrediente/no_image.png', NULL),
(6572, 'Centeio', '', '../../css/img/ingrediente/no_image.png', NULL),
(6573, 'Cerefólio', '', '../../css/img/ingrediente/no_image.png', NULL),
(6574, 'Cereja', '', '../../css/img/ingrediente/no_image.png', NULL),
(6575, 'Cereja ao Maraschino', '', '../../css/img/ingrediente/no_image.png', NULL),
(6576, 'Cerejas em Calda', '', '../../css/img/ingrediente/no_image.png', NULL),
(6577, 'Cerveja', '', '../../css/img/ingrediente/no_image.png', NULL),
(6578, 'Cevada', '', '../../css/img/ingrediente/no_image.png', NULL),
(6947, 'matcha', '', '../../css/img/ingrediente/no_image.png', 28),
(6948, 'mate', '', '../../css/img/ingrediente/no_image.png', 28),
(6949, 'refrigerante de guaraná', '', '../../css/img/ingrediente/no_image.png', 28),
(6950, 'refrigerante de laranja', '', '../../css/img/ingrediente/no_image.png', 28),
(6951, 'refrigerante de limão', '', '../../css/img/ingrediente/no_image.png', 28),
(6952, 'rooibos', '', '../../css/img/ingrediente/no_image.png', 28),
(6953, 'suco de abacaxi', '', '../../css/img/ingrediente/no_image.png', 28),
(6954, 'suco de açaí', '', '../../css/img/ingrediente/no_image.png', 28),
(6955, 'suco de acerola', '', '../../css/img/ingrediente/no_image.png', 28),
(6956, 'suco de caju', '', '../../css/img/ingrediente/no_image.png', 28),
(6957, 'suco de cranberry', '', '../../css/img/ingrediente/no_image.png', 28),
(6958, 'suco de figo', '', '../../css/img/ingrediente/no_image.png', 28),
(6959, 'suco de goiaba', '', '../../css/img/ingrediente/no_image.png', 28),
(6960, 'suco de grapefruit', '', '../../css/img/ingrediente/no_image.png', 28),
(6961, 'suco de groselha', '', '../../css/img/ingrediente/no_image.png', 28),
(6962, 'suco de laranja', '', '../../css/img/ingrediente/no_image.png', 28),
(6963, 'suco de limão', '', '../../css/img/ingrediente/no_image.png', 28),
(6964, 'suco de maçã', '', '../../css/img/ingrediente/no_image.png', 28),
(6965, 'suco de manga', '', '../../css/img/ingrediente/no_image.png', 28),
(6966, 'suco de maracujá', '', '../../css/img/ingrediente/no_image.png', 28),
(6967, 'suco de melancia', '', '../../css/img/ingrediente/no_image.png', 28),
(6968, 'suco de melão', '', '../../css/img/ingrediente/no_image.png', 28),
(6969, 'suco de morango', '', '../../css/img/ingrediente/no_image.png', 28),
(6970, 'suco de pêssego', '', '../../css/img/ingrediente/no_image.png', 28),
(6971, 'suco de tangerina', '', '../../css/img/ingrediente/no_image.png', 28),
(6972, 'suco de uva', '', '../../css/img/ingrediente/no_image.png', 28),
(6973, 'suco em pó', '', '../../css/img/ingrediente/no_image.png', 28),
(6974, 'suco em pó de limão', '', '../../css/img/ingrediente/no_image.png', 28),
(6975, 'suco em pó de morango', '', '../../css/img/ingrediente/no_image.png', 28),
(6976, 'tucupi', '', '../../css/img/ingrediente/no_image.png', 28),
(6977, 'xarope de framboesa', '', '../../css/img/ingrediente/no_image.png', 28),
(6978, 'xarope de groselha', '', '../../css/img/ingrediente/no_image.png', 28),
(6979, 'apresuntado', '', '../../css/img/ingrediente/no_image.png', 10),
(7583, 'Amor Perfeito', 'Amores Perfeitos', '../../css/img/ingrediente/no_image.png', 18),
(7584, 'Borragem', 'Borragens', '../../css/img/ingrediente/no_image.png', 18),
(7585, 'Dente de Leão', 'Dentes de Leão', '../../css/img/ingrediente/no_image.png', 18),
(7586, 'Hibisco', 'Hibiscos', '../../css/img/ingrediente/no_image.png', 18),
(7587, 'Jasmim', 'Jasmins', '../../css/img/ingrediente/no_image.png', 18),
(7588, 'Rosa Comestível', 'Rosas Comestíveis', '../../css/img/ingrediente/no_image.png', 18),
(7589, 'Rosmaninho', 'Rosmaninhos', '../../css/img/ingrediente/no_image.png', 18),
(7590, 'Violeta', 'Violetas', '../../css/img/ingrediente/no_image.png', 18),
(7694, 'Amêijoa', 'Amêijoas', '../../css/img/ingrediente/no_image.png', 14),
(7695, 'Aratu', 'Aratus', '../../css/img/ingrediente/no_image.png', 14),
(7696, 'Berbigão', 'Berbigões', '../../css/img/ingrediente/no_image.png', 14),
(7697, 'Camarão Seco', 'Camarões Secos', '../../css/img/ingrediente/no_image.png', 14),
(7698, 'Carangueijo', 'Carangueijos', '../../css/img/ingrediente/no_image.png', 14),
(7699, 'Chocos', 'Chocos', '../../css/img/ingrediente/no_image.png', 14),
(7700, 'Delicias do Mar', 'Delícias do Mar', '../../css/img/ingrediente/no_image.png', 14),
(7701, 'Enguias', 'Enguias', '../../css/img/ingrediente/no_image.png', 14),
(7702, 'Gambas', 'Gambas', '../../css/img/ingrediente/no_image.png', 14),
(7703, 'Kani', 'Kani', '../../css/img/ingrediente/no_image.png', 14),
(7704, 'Lagostim', 'Lagostins', '../../css/img/ingrediente/no_image.png', 14),
(7705, 'Ostra', 'Ostras', '../../css/img/ingrediente/no_image.png', 14),
(7706, 'Ovos de Tainha', 'Ovos de Tainha', '../../css/img/ingrediente/no_image.png', 14),
(7707, 'Perolas do Mar', 'Perolas do Mar', '../../css/img/ingrediente/no_image.png', 14),
(7708, 'Polvo', 'Polvos', '../../css/img/ingrediente/no_image.png', 14),
(7709, 'Pota', 'Potas', '../../css/img/ingrediente/no_image.png', 14),
(7710, 'Siri', 'Siris', '../../css/img/ingrediente/no_image.png', 14),
(7711, 'Sururu', 'Sururus', '../../css/img/ingrediente/no_image.png', 14),
(7712, 'Tinta de Lula', 'Tintas de Lula', '../../css/img/ingrediente/no_image.png', 14),
(7713, 'Vieira', 'Vieiras', '../../css/img/ingrediente/no_image.png', 14),
(7714, 'Vôngole', 'Vôngoles', '../../css/img/ingrediente/no_image.png', 14),
(7932, 'nata', 'Natas', '../../css/img/ingrediente/no_image.png', 8),
(7933, 'ricota', 'Ricotas', '../../css/img/ingrediente/no_image.png', 8),
(7934, 'requeijão', 'Requeijões', '../../css/img/ingrediente/no_image.png', 8),
(7935, 'yogurte', 'Yogurtes', '../../css/img/ingrediente/no_image.png', 8),
(7936, 'Ovo Tipo 2', 'Ovos Tipo 2', '../../css/img/ingrediente/no_image.png', NULL),
(7937, 'Ovo Tipo 1', 'Ovos Tipo 1', '../../css/img/ingrediente/no_image.png', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingrediente_quantidade`
--

DROP TABLE IF EXISTS `ingrediente_quantidade`;
CREATE TABLE IF NOT EXISTS `ingrediente_quantidade` (
  `id_ingrediente_quantidade` int NOT NULL AUTO_INCREMENT,
  `nome_singular_ingrediente_quantidade` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `nome_plural_ingrediente_quantidade` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ingrediente_quantidade`),
  UNIQUE KEY `nome_singular_ingrediente_quantidade` (`nome_singular_ingrediente_quantidade`,`nome_plural_ingrediente_quantidade`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `ingrediente_quantidade`
--

INSERT INTO `ingrediente_quantidade` (`id_ingrediente_quantidade`, `nome_singular_ingrediente_quantidade`, `nome_plural_ingrediente_quantidade`) VALUES
(40, '1/2 colher de chá', '1/2 colheres de chá'),
(28, '1/2 colher de sobremesa', '1/2 colheres de sobremesa'),
(39, '1/2 colher de sopa', '1/2 colheres de sopa'),
(20, '1/2 xícara de chá', '1/2 xícaras de chá'),
(24, '1/3 xícara de chá', '1/3 xícaras de chá'),
(41, '1/4 colher de chá', '1/4 colheres de chá'),
(21, '1/4 xícara de chá', '1/4 xícaras de chá'),
(23, '1/8 xícara de chá', '1/8 xícaras de chá'),
(25, '2/3 xícara de chá', '2/3 xícaras de chá'),
(22, '3/4 xícara de chá', '3/4 xícaras de chá'),
(1, 'a gosto', 'a gosto'),
(45, 'bola', 'bolas'),
(48, 'borrifada', 'borrifadas'),
(37, 'caixa', 'caxais'),
(12, 'colher de café', 'colheres de café'),
(13, 'colher de chá', 'colheres de chá'),
(14, 'colher de sobremesa', 'colheres de sobremesa'),
(15, 'colher de sopa', 'colheres de sopa'),
(9, 'copo', 'copos'),
(16, 'copo americano', 'copos americanos'),
(17, 'copo requeijão', 'copos de requeijão'),
(46, 'cubo', 'cubos'),
(47, 'embalagem', 'embalagens'),
(4, 'fatia', 'fatias'),
(26, 'garrafa', 'garrafas'),
(7, 'grama', 'gramas'),
(38, 'lata', 'latas'),
(10, 'litro', 'litros'),
(42, 'maço', 'maços'),
(11, 'mililitro', 'mililitros'),
(18, 'pacote', 'pacotes'),
(2, 'pedaço', 'pedaços'),
(5, 'pitada', 'pitadas'),
(3, 'punhado', 'punhados'),
(6, 'quilo', 'quilos'),
(43, 'ramo', 'ramos'),
(27, 'saco', 'sacos'),
(44, 'talo', 'talos'),
(8, 'unidade', 'unidades'),
(19, 'xícara de chá', 'xícaras de chá');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_de_ingredientes`
--

DROP TABLE IF EXISTS `lista_de_ingredientes`;
CREATE TABLE IF NOT EXISTS `lista_de_ingredientes` (
  `fk_id_receita` int DEFAULT NULL,
  `fk_id_ingrediente` int DEFAULT NULL,
  `qtdIngrediente_lista` decimal(10,3) DEFAULT NULL,
  `tipoQtdIngrediente_lista` int NOT NULL,
  KEY `fk_id_ingrediente` (`fk_id_ingrediente`),
  KEY `fk_id_ingrediente_quantidade` (`tipoQtdIngrediente_lista`) USING BTREE,
  KEY `fk_id_receita` (`fk_id_receita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `lista_de_ingredientes`
--

INSERT INTO `lista_de_ingredientes` (`fk_id_receita`, `fk_id_ingrediente`, `qtdIngrediente_lista`, `tipoQtdIngrediente_lista`) VALUES
(1, 396, 1.000, 20),
(1, 95, 1.000, 19),
(1, 397, 7.000, 15),
(1, 89, 4.000, 15),
(1, 398, 4.000, 15),
(2, 88, 1.000, 37),
(2, 89, 0.500, 37),
(2, 401, 1.000, 15),
(2, 400, 90.750, 7),
(2, 402, 1.000, 15),
(3, 88, 200.000, 7),
(3, 408, 50.000, 7),
(3, 409, 50.000, 7),
(3, 110, 1.000, 1),
(3, 215, 2.000, 15),
(3, 405, 1.000, 15),
(4, 110, 1.000, 1),
(4, 409, 50.000, 7),
(4, 410, 100.000, 7),
(4, 211, 50.000, 7),
(4, 89, 0.500, 37),
(4, 88, 1.000, 38),
(5, 419, 80.000, 7),
(5, 97, 3.000, 7),
(5, 420, 200.000, 7),
(5, 422, 180.000, 7),
(5, 393, 480.000, 11),
(5, 94, 100.000, 11),
(5, 423, 10.000, 11),
(5, 98, 8.000, 7),
(5, 252, 140.000, 7),
(5, 424, 160.000, 7),
(5, 425, 3.000, 8),
(5, 421, 380.000, 7),
(6, 19, 3.000, 8),
(6, 426, 170.000, 7),
(6, 89, 200.000, 7),
(81, 88, 1.000, 38),
(81, 89, 1.000, 38),
(81, 62, 1.000, 18),
(81, 61, 1.000, 18),
(81, 188, 1.000, 38),
(81, 94, 1.000, 19),
(82, 90, 1.000, 38),
(82, 91, 1.000, 38),
(82, 428, 1.000, 38),
(82, 92, 2.000, 18),
(82, 94, 1.000, 19),
(83, 1, 1.000, 40),
(88, 19, 10.000, 8),
(88, 110, 225.000, 7),
(88, 252, 225.000, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `porcao_quantidade`
--

DROP TABLE IF EXISTS `porcao_quantidade`;
CREATE TABLE IF NOT EXISTS `porcao_quantidade` (
  `id_porcao` int NOT NULL AUTO_INCREMENT,
  `nome_singular_porcao` varchar(40) COLLATE utf8mb3_unicode_ci NOT NULL,
  `nome_plural_porcao` varchar(40) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_porcao`),
  UNIQUE KEY `nome_singular_porcao` (`nome_singular_porcao`,`nome_plural_porcao`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `porcao_quantidade`
--

INSERT INTO `porcao_quantidade` (`id_porcao`, `nome_singular_porcao`, `nome_plural_porcao`) VALUES
(9, 'copo', 'copos'),
(4, 'fatia', 'fatias'),
(7, 'grama', 'gramas'),
(10, 'litro', 'litros'),
(11, 'mililitro', 'mililitros'),
(2, 'pedaço', 'pedaços'),
(5, 'pessoa', 'pessoas'),
(1, 'porção', 'porções'),
(3, 'prato', 'pratos'),
(6, 'quilo', 'quilos'),
(8, 'unidade', 'unidades'),
(12, 'xícara', 'xícaras');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receita`
--

DROP TABLE IF EXISTS `receita`;
CREATE TABLE IF NOT EXISTS `receita` (
  `id_receita` int NOT NULL AUTO_INCREMENT,
  `nome_receita` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroPorcao_receita` decimal(10,3) NOT NULL,
  `tipoPorcao_receita` int NOT NULL,
  `tempoPreparoHora_receita` int NOT NULL,
  `tempoPreparoMinuto_receita` int NOT NULL,
  `modoPreparo_receita` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_receita` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '../css/img/receita/no_image.png',
  `categoria_receita` int DEFAULT NULL,
  `fk_id_usuario` int NOT NULL,
  PRIMARY KEY (`id_receita`),
  KEY `fk_tipoPorcao` (`tipoPorcao_receita`),
  KEY `fk_categoria_receita` (`categoria_receita`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `receita`
--

INSERT INTO `receita` (`id_receita`, `nome_receita`, `numeroPorcao_receita`, `tipoPorcao_receita`, `tempoPreparoHora_receita`, `tempoPreparoMinuto_receita`, `modoPreparo_receita`, `imagem_receita`, `categoria_receita`, `fk_id_usuario`) VALUES
(1, 'Soda Italiana Cremosa', 2.000, 1, 0, 5, '1. Preencha um copo alto com ¾ de xícara de gelo.\n2. Despeje o xarope sobre o gelo.\n3. Adicione a água com gás.\n4. Finalize com creme de leite e/ou chantilly.\n5. Misture e aproveite!', '../css/img/receita/italian-cream-soda.png', 25, 1),
(2, 'Brigadeiro de Pistache', 25.000, 1, 8, 20, '1. Em uma panela, coloque o Leite Moça, o Creme de Leite, o pistache triturado, a pasta de pistache e a glucose de milho e misture bem.\r\n2. Leve ao fogo médio, mexendo sempre, por cerca de 8 minutos, ou até desgrudar do fundo da panela.\r\n3. Coloque em um prato untado com manteiga e deixe descansar por cerca de 8 horas.\r\n4. Com as mãos untadas, enrole em forma de brigadeiros, passe no pistache triturado e sirva.', '../css/img/receita/brigadeiro-de-pistache.png', 29, 1),
(3, 'Brigadeiro Casadinho de Morango e Ninho', 12.000, 8, 1, 45, '1. Em uma panela, adicione o leite condensado, o leite em pó e a manteiga para fazer o brigadeiro de Ninho.\r\n\r\n2. Cozinhe em fogo baixo, mexendo sempre até que a mistura desgrude do fundo da panela (ponto de brigadeiro).\r\n\r\n3. Retire o brigadeiro de Ninho do fogo e deixe esfriar até estar em temperatura ambiente para modelar.\r\n\r\n4. Em outra panela, adicione o leite condensado, o chocolate branco, a manteiga e o pó para preparo de morango para fazer o brigadeiro de morango.\r\n\r\n5. Cozinhe em fogo baixo, mexendo até que a mistura desgrude do fundo da panela (mesmo ponto do brigadeiro de Ninho).\r\n\r\n6. Retire o brigadeiro de morango do fogo e deixe esfriar até atingir a temperatura ideal para modelar.\r\n\r\n7. Com a ajuda de uma balança, pese 4 gramas de brigadeiro de Ninho e faça uma bolinha.\r\n\r\n8. Pese 4 gramas de brigadeiro de morango e faça outra bolinha.\r\n\r\n9. Achate as bolinhas separadamente antes de enrolá-las para garantir uma divisão perfeita no meio do doce.\r\n\r\n10. Una as duas partes (Ninho e morango) e enrole para formar o casadinho.\r\n\r\n11. Passe os casadinhos imediatamente no açúcar refinado, enquanto ainda há gordura ativada para que o açúcar adira bem à superfície.\r\n\r\n12. Coloque os casadinhos em forminhas, cuidando para que a divisão entre os dois sabores (Ninho e morango) fique bem no meio do doce.\r\n\r\n13. Os casadinhos estão prontos para serem servidos!\r\n\r\nDica: O truque para uma divisão perfeita entre os dois sabores é achatar as bolinhas antes de enrolá-las. Isso garante que a separação fique visível e o resultado seja esteticamente bonito.', '../css/img/receita/casadinho-morango.png', 29, 1),
(4, 'Brigadeiro Romeu e Julieta', 12.000, 1, 0, 90, '1. Em uma panela, misture o Leite Moça, o  Creme de Leite, o queijo ralado e o chocolate branco picado. Leve ao fogo médio, mexendo sempre, por cerca de 8-10 minutos até que o brigadeiro fique no ponto de enrolar.\r\n2. Transfira para um prato untado, cubra com plástico-filme e deixe esfriar por completo.\r\n3. Após, porcione quantidades do brigadeiro, faça bolinhas, abra-as na palma da mão e recheie-as com alguns pedaços da goiabada picada. Feche e boleie para obter um brigadeiro. Passe-os brigadeiros no açúcar cristal, coloque-os em forminhas próprias e sirva.', '../css/img/receita/brigadeiro-romeu-e-julieta.png', 29, 1),
(5, 'Hot Roll California', 36.000, 8, 0, 90, '1. Reúna os ingredientes para fazer esse hot roll califórnia, uma variação deliciosa de sushi. Pegue também uma esteira de bambu e mantenha uma tigela com água para umedecer os dedos durante o processo;\n2. Cozinhe o arroz para sushi conforme as instruções do pacote. Após cozido, tempere com vinagre de arroz, açúcar e sal. Deixe esfriar;\n3. Descasque a manga e pique em fatias finas. Lave e pique o pepino em fatias finas. Pique também o kani em fatias finas. Tente deixar todos os ingredientes fatiados com a mesma espessura;\n4. Cubra a esteira para sushi com filme plástico e coloque em cima a folha de alga nori;\n5. Umedeça as mãos com água para evitar que o arroz grude e espalhe uma camada de arroz sobre a alga, deixando cerca de 1 cm de alga livre na borda superior;\n6. Coloque tiras de pepino, manga e kani sobre o arroz, posicione horizontalmente e um pouco abaixo do centro;\n7. Use a esteira de bambu para enrolar o sushi de forma firme, pressionando suavemente para compactar os ingredientes. Umedeça, levemente a borda da alga com um pouco de água para facilitar o fechamento;\n8. Em uma recipiente, misture a farinha e a água. Em outro recipiente, coloque a farinha panko;\n9. Mergulhe cada peça na massa até ficar completamente envolvida. Em seguida, passe cada peça na farinha panko;\n10. Numa panela média, coloque o óleo e leve ao fogo alto para aquecer. Quando o óleo estiver quente, abaixe o fogo;\n11. Adicione as peças no óleo e deixe que fritem até que estejam douradas e crocantes. Com uma escumadeira, retire cada peça e coloque em um prato forrado com papel-toalha para remover o excesso de óleo;\n12. Sirva o hot roll california quente, acompanhado de shoyu, wasabi ou molho tarê, se desejar. Bom apetite!', '../css/img/receita/hot-roll-california.png', 3, 1),
(6, 'Mousse de Chocolate', 6.000, 1, 0, 30, '1. Reúna todos os ingredientes da mousse de chocolate;\n2. Em um recipiente, coloque o chocolate e derreta em banho-maria ou no micro-ondas (de 30 em 30 segundos);\n3. Assim que o chocolate estiver totalmente derretido, acrescente o creme de leite e misture até obter uma ganache de chocolate;\n4. Em uma batedeira ou à mão, bata as claras de ovo até obter as claras em neve;\n5. Depois, adicione as claras em neve ao recipiente com a ganache de chocolate. Misture delicadamente, fazendo movimento circulares, até obter um creme homogêneo;\n6. Transfira a mousse para um refratário, cubra com plástico filme ou tampa e leve à geladeira por cerca de 2 horas;\n7. Agora é só servir gelado. Bom apetite!\n', '../css/img/receita/mousse-de-chocolate.png', 29, 1),
(81, 'Creme da Noviça', 8.000, 1, 2, 10, '1. Dilua as gelatinas na água fervendo, coloque no liquidificador o restante dos ingredientes e as gelatinas dissolvidas em água quente.\r\n\r\n2. Bata bem.\r\n\r\n3. Coloquem em uma forma média de pudim.\r\n\r\n4. Leve à geladeira por mais ou menos 2 horas.\r\n\r\n5. Depois de firme é só desenformar e servir.', '../css/img/receita/6747511c7e700.png', 29, 1),
(82, 'Creme da Noviça Sem Lactose', 8.000, 1, 2, 10, '1. Dilua as gelatinas na água fervendo, coloque no liquidificador o restante dos ingredientes e as gelatinas dissolvidas em água quente.\r\n\r\n2. Bata bem.\r\n\r\n3. Coloquem em uma forma média de pudim.\r\n\r\n4. Leve à geladeira por mais ou menos 2 horas.\r\n\r\n5. Depois de firme é só desenformar e servir.', '../css/img/receita/6747511c7e700.png', 23, 1),
(83, 'Deletar', 1.000, 9, 0, 1, 'aaaaaaa', '../css/img/receita/no_image.png', 44, 1),
(88, 'Pão de Ló', 8.000, 9, 0, 60, '1. Reúna todos os ingredientes;\r\n2. Um recipiente com ovos e açúcar.\r\n3. Coloque os ovos e o açúcar na batedeira;\r\n4. Um recipiente com um creme de ovos e açúcar.\r\n5. Bata em velocidade baixa e gradualmente, vá aumentando a velocidade até chegar ao máximo até que o creme que se forma quase transborde;\r\n6. Um recipiente com farinha e creme de ovos e açúcar.\r\n7. Desligue a batedeira e peneire a farinha na massa e, com uma espátula, misture bem a farinha na massa até incorporar;\r\n8. Uma assadeira com a massa crua do pão de ló.\r\n9. Despeje a massa em uma forma (26 cm de diâmetro) forrada com papel manteiga e leve ao forno preaquecido a 180 °C por 45 minutos.\r\n10. Um bolo pão de ló com uma fatia sendo retirada.\r\n11. Desenforme, ainda morno, cuidadosamente e sirva. Bom apetite!', '../css/img/receita/6748ced5ac111.png', 36, 173);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sugestao`
--

DROP TABLE IF EXISTS `sugestao`;
CREATE TABLE IF NOT EXISTS `sugestao` (
  `id_sugestao` int NOT NULL AUTO_INCREMENT,
  `nome_sugestao` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `categoria_sugestao` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fk_id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_sugestao`),
  KEY `fk_id_usuario` (`fk_id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `sugestao`
--

INSERT INTO `sugestao` (`id_sugestao`, `nome_sugestao`, `categoria_sugestao`, `fk_id_usuario`) VALUES
(22, 'Ovo Tipo 2', 'Ingrediente', 173);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `senha_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `imagem_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '../css/img/usuario/no_image.png',
  `statusAdministrador_usuario` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'c',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `unique_nome_usuario` (`nome_usuario`),
  UNIQUE KEY `unique_email_usuario` (`email_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `recuperar_senha`, `imagem_usuario`, `statusAdministrador_usuario`) VALUES
(1, 'Admin', 'amandaveigafurtado@gmail.com', '$2y$10$QZEMW75b3179MRkwDPWsJ.FvMeSFvyB2b7KmbBir2y/G/PL9iWbEC', '$2y$10$dK3SGRRgT8jfSGLCjeM91Og0PQze0TMsOC1YIjTB9N69Vvy5Ftifu', '../css/img/usuario/67479c0e59df9_67439abc6ae64_image.png', 'a'),
(2, 'Usuario 1', 'a@gmail.com', '$2y$10$QZEMW75b3179MRkwDPWsJ.FvMeSFvyB2b7KmbBir2y/G/PL9iWbEC', NULL, '../css/img/ingrediente/no_image.png', 'b'),
(3, 'Usuario 2', 'a21', 'aa2', NULL, '../css/img/ingrediente/no_image.png', 'b'),
(4, 'Usuario 3', '07/10@gmail.com', '$2y$10$4Xe5NhKvxAY8L1gmHDV0IuLRwNQFaKpmVDWC9T0mE.5HbxHnS8foq', NULL, '../css/img/ingrediente/no_image.png', 'c'),
(5, 'Usuario 4', '09/10@gmail.co', '$2y$10$lDDrwTno97ZXyrZ.9GtXm.gdcItsQhZ9.U7iMqJg/pXs5oL7Y8pc6', NULL, '../css/img/ingrediente/no_image.png', 'b'),
(6, 'Usuario 5', '1234@gmail.com', '$2y$10$no8XZ8EeHc5.wMuzMhnlLuprUwjukGDe14tbX0a3EedyJH/DH4Nkq', NULL, '../css/img/ingrediente/no_image.png', 'c'),
(172, 'Usuario 6', 'am@am.com', '$2y$10$Owwsl2X4XUt8ar/zXEQaW.9JIJOTCDyLWIxiZPDfj04hpHXh9ZbjW', NULL, '../css/img/usuario/674893dd9c50e_6326055.png', 'c'),
(173, 'Amanda', 'usuarioteste@gmail.com', '$2y$10$cBTGvDRyGEBSkuwt8QRng.RILjK9bnQ9yuwjHKG/H5pe0o8dprlMW', NULL, '../css/img/usuario/6748ce5de7220_6326055.png', 'c');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `view_lista_ingredientes`
-- (Veja abaixo para a visão atual)
--
DROP VIEW IF EXISTS `view_lista_ingredientes`;
CREATE TABLE IF NOT EXISTS `view_lista_ingredientes` (
`fk_id_receita` int
,`fk_id_ingrediente` int
,`qtdIngrediente_lista` decimal(10,3)
,`tipoQtdIngrediente_lista` int
,`nome_receita` varchar(220)
);

-- --------------------------------------------------------

--
-- Estrutura para view `view_lista_ingredientes`
--
DROP TABLE IF EXISTS `view_lista_ingredientes`;

DROP VIEW IF EXISTS `view_lista_ingredientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_lista_ingredientes`  AS SELECT `li`.`fk_id_receita` AS `fk_id_receita`, `li`.`fk_id_ingrediente` AS `fk_id_ingrediente`, `li`.`qtdIngrediente_lista` AS `qtdIngrediente_lista`, `li`.`tipoQtdIngrediente_lista` AS `tipoQtdIngrediente_lista`, `r`.`nome_receita` AS `nome_receita` FROM (`lista_de_ingredientes` `li` left join `receita` `r` on((`li`.`fk_id_receita` = `r`.`id_receita`))) ;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_comentario_receita` FOREIGN KEY (`fk_id_receita`) REFERENCES `receita` (`id_receita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD CONSTRAINT `fk_categoria_ingrediente` FOREIGN KEY (`fk_id_categoria_ingrediente`) REFERENCES `categoria_ingrediente` (`id_categoria_ingrediente`);

--
-- Restrições para tabelas `lista_de_ingredientes`
--
ALTER TABLE `lista_de_ingredientes`
  ADD CONSTRAINT `fk_id_ingrediente` FOREIGN KEY (`fk_id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_receita` FOREIGN KEY (`fk_id_receita`) REFERENCES `receita` (`id_receita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipoQtdIngrediente_lista` FOREIGN KEY (`tipoQtdIngrediente_lista`) REFERENCES `ingrediente_quantidade` (`id_ingrediente_quantidade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `receita`
--
ALTER TABLE `receita`
  ADD CONSTRAINT `fk_categoria_receita` FOREIGN KEY (`categoria_receita`) REFERENCES `categoria_culinaria` (`id_categoria_culinaria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipoPorcao` FOREIGN KEY (`tipoPorcao_receita`) REFERENCES `porcao_quantidade` (`id_porcao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `sugestao`
--
ALTER TABLE `sugestao`
  ADD CONSTRAINT `fk_sugestao_usuario` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
