-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/09/2024 às 19:42
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categoria_culinaria`
--

INSERT INTO `categoria_culinaria` (`id_categoria_culinaria`, `nome_categoria_culinaria`) VALUES
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
  `texto_comentario` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
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
  `imagem_ingrediente` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '../css/img/ingrediente/no_image.png',
  `fk_id_categoria_ingrediente` int DEFAULT NULL,
  PRIMARY KEY (`id_ingrediente`),
  UNIQUE KEY `nome_ingrediente` (`nome_ingrediente`),
  KEY `fk_categoria_ingrediente` (`fk_id_categoria_ingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nome_ingrediente`, `imagem_ingrediente`, `fk_id_categoria_ingrediente`) VALUES
(1, 'Abacate', '../../css/img/ingrediente/1.png', 4),
(2, 'Abacaxi', '../css/img/ingrediente/2.png', 4),
(3, 'Açaí (Fruta)', '../css/img/ingrediente/3.png', 4),
(4, 'Banana', '../css/img/ingrediente/4.png', 4),
(5, 'Goiaba', '../css/img/ingrediente/5.png', 4),
(6, 'Kiwi', '../css/img/ingrediente/6.png', 4),
(7, 'Laranja', '../css/img/ingrediente/7.png', 4),
(8, 'Limão', '../css/img/ingrediente/8.png', 4),
(9, 'Maçã', '../css/img/ingrediente/9.png', 4),
(10, 'Mamão', '../css/img/ingrediente/10.png', 4),
(12, 'Abiu', '../css/img/ingrediente/12.png', 4),
(13, 'Ameixa', '../css/img/ingrediente/13.png', 4),
(17, 'Abacaxi Pérola', '../css/img/ingrediente/2.png', 4),
(18, 'Abacaxi Havaí', '../css/img/ingrediente/2.png', 4),
(19, 'Ovo', '../css/img/ingrediente/no_image.png', 8),
(21, 'Polpa de Açaí', '../css/img/ingrediente/3.png', 5),
(23, 'Banana Verde', '../css/img/ingrediente/4.png', 4),
(24, 'Banana Da Terra', '../css/img/ingrediente/4.png', 4),
(25, 'Banana Nanica', '../css/img/ingrediente/4.png', 4),
(26, 'Banana Prata', '../css/img/ingrediente/4.png', 4),
(31, 'Kiwi Dourado / Kiwi Amarelo', '../css/img/ingrediente/6.png', 4),
(32, 'Goiaba Branca', '../css/img/ingrediente/5.png', 4),
(33, 'Goiaba Vermelha', '../css/img/ingrediente/5.png', 4),
(34, 'Laranja Lima', '../css/img/ingrediente/7.png', 4),
(35, 'Laranja Pera', '../css/img/ingrediente/7.png', 4),
(36, 'Limão Taiti', '../css/img/ingrediente/8.png', 4),
(38, 'Limão Siciliano', '../css/img/ingrediente/8.png', 4),
(42, 'Maçã Fuji', '../css/img/ingrediente/9.png', 4),
(43, 'Maçã Gala', '../css/img/ingrediente/9.png', 4),
(44, 'Maçã Granny Smith', '../css/img/ingrediente/9.png', 4),
(45, 'Maçã Red Argentina', '../css/img/ingrediente/9.png', 4),
(46, 'Mamão Formosa', '../css/img/ingrediente/10.png', 4),
(47, 'Mamão Papaya', '../css/img/ingrediente/10.png', 4),
(48, 'Ameixa Sem Caroço', '../css/img/ingrediente/13.png', 4),
(49, 'Polpa de Abacaxi', '../css/img/ingrediente/2.png', 5),
(50, 'Polpa de Abiu', '../css/img/ingrediente/12.png', 5),
(52, 'Ameixa Preta', '../css/img/ingrediente/13.png', 4),
(53, 'Polpa de Ameixa Preta', '../css/img/ingrediente/13.png', 5),
(54, 'Polpa de Ameixa', '../css/img/ingrediente/13.png', 5),
(55, 'Polpa de Banana', '../css/img/ingrediente/4.png', 5),
(56, 'Polpa de Goiaba', '../css/img/ingrediente/5.png', 5),
(58, 'Gelatina em Pó Sabor Algodão Doce', '../css/img/ingrediente/58.jpg', 26),
(59, 'Gelatina em Pó Sabor Amora', '../css/img/ingrediente/no_image.png', 26),
(60, 'Gelatina em Pó Sabor Açaí com Banana', '../css/img/ingrediente/no_image.png', 26),
(61, 'Gelatina em Pó Sabor Morango', '../css/img/ingrediente/61.jpg', 26),
(62, 'Gelatina em Pó Sabor Uva\n', '../css/img/ingrediente/62.jpg', 26),
(71, 'Gelatina em Pó Sabor Abacaxi', '../css/img/ingrediente/71.jpg', 26),
(72, 'Gelatina em Pó Sabor Cereja', '../css/img/ingrediente/61.jpg', 26),
(75, 'Gelatina em Pó Sabor Tutti-Frutti', '../css/img/ingrediente/75.jpg', 26),
(76, 'Gelatina em Pó Sabor Framboesa', '../css/img/ingrediente/61.jpg', 26),
(77, 'Gelatina em Pó Sabor Limão', '../css/img/ingrediente/77.jpg', 26),
(78, 'Gelatina em Pó Sabor Cereja com Amora Silvestre', '../css/img/ingrediente/no_image.png', 26),
(83, 'Gelatina em Pó Sabor Maracujá', '../css/img/ingrediente/71.jpg', 26),
(84, 'Gelatina em Pó Sabor Pessego', '../css/img/ingrediente/71.jpg', 26),
(87, 'Gelatina Incolor Sem Sabor', '../css/img/ingrediente/87.png', 26),
(88, 'Leite Condensado / Leite Moça', '../css/img/ingrediente/88.png', 8),
(89, 'Creme de Leite', '../css/img/ingrediente/89.png', 8),
(90, 'Leite Condensado / Leite Moça (Sem Lactose)', '../css/img/ingrediente/88.png', 8),
(91, 'Creme de Leite (Sem Lactose)', '../css/img/ingrediente/89.png', 8),
(92, 'Gelatina em Pó de Qualquer Sabor', '../css/img/ingrediente/92.png', 26),
(94, 'Água', '../css/img/ingrediente/94.png', 28),
(95, 'Água com Gás', '../css/img/ingrediente/94.png', 28),
(96, 'Água Alcalina', '../css/img/ingrediente/94.png', 28),
(97, 'Sal', '../css/img/ingrediente/87.png', 1),
(98, 'Açúcar', '../css/img/ingrediente/87.png', 1),
(101, 'Sal Refinado', '../css/img/ingrediente/87.png', NULL),
(102, 'Sal Marinho', '../css/img/ingrediente/87.png', NULL),
(103, 'Sal do Himalaia', '../css/img/ingrediente/87.png', NULL),
(104, 'Pedra de Sal Rosa do Himalaia', '../css/img/ingrediente/87.png', NULL),
(105, 'Flor de Sal', '../css/img/ingrediente/87.png', NULL),
(106, 'Sal Kosher', '../css/img/ingrediente/87.png', NULL),
(107, 'Sal Maldon', '../css/img/ingrediente/87.png', NULL),
(108, 'Sal Light', '../css/img/ingrediente/87.png', NULL),
(109, 'Açúcar Cristal', '../css/img/ingrediente/87.png', 16),
(110, 'Açúcar Refinado', '../css/img/ingrediente/87.png', 16),
(111, 'Açúcar Mascavo', '../css/img/ingrediente/87.png', 16),
(112, 'Açúcar Demerara', '../css/img/ingrediente/112.png', 16),
(113, 'Açúcar de Coco', '../css/img/ingrediente/87.png', 16),
(114, 'Açúcar Light', '../css/img/ingrediente/87.png', 16),
(115, 'Flocos de Aveia', '../css/img/ingrediente/no_image.png', 20),
(117, 'Whiskey Teor 100', '../css/img/ingrediente/no_image.png', 27),
(118, 'Whiskey Teor 80', '../css/img/ingrediente/no_image.png', 27),
(119, 'Whiskey', '../css/img/ingrediente/no_image.png', 27),
(120, 'Whiskey Teor 86', '../css/img/ingrediente/no_image.png', 27),
(121, 'Whiskey Teor 90', '../css/img/ingrediente/no_image.png', 27),
(122, 'Whiskey Teor 94', '../css/img/ingrediente/no_image.png', 27),
(135, 'Vodka Teor 94', '../css/img/ingrediente/no_image.png', 27),
(136, 'Vodka Teor 90', '../css/img/ingrediente/no_image.png', 27),
(137, 'Vodka Teor 80', '../css/img/ingrediente/no_image.png', 27),
(138, 'Vodka Teor 100', '../css/img/ingrediente/no_image.png', 27),
(139, 'Vinho', '../css/img/ingrediente/no_image.png', 27),
(140, 'Vinho Tinto', '../css/img/ingrediente/no_image.png', 27),
(141, 'Vinho Rosé', '../css/img/ingrediente/no_image.png', 27),
(142, 'Vinho Moscatel', '../css/img/ingrediente/no_image.png', 27),
(143, 'Vinho de Maçã', '../css/img/ingrediente/no_image.png', 27),
(144, 'Vinho de Jenipapo', '../css/img/ingrediente/no_image.png', 27),
(145, 'Vinho Branco Seco', '../css/img/ingrediente/no_image.png', 27),
(146, 'Vinho Branco Médio', '../css/img/ingrediente/no_image.png', 27),
(147, 'Vinho Aperitivo Seco', '../css/img/ingrediente/no_image.png', 27),
(148, 'Vinho Aperitivo Doce', '../css/img/ingrediente/no_image.png', 27),
(163, 'Arroz', '../css/img/ingrediente/no_image.png', 20),
(164, 'Arroz Agulhinha', '../css/img/ingrediente/no_image.png', 20),
(165, 'Arroz Arbóreo', '../css/img/ingrediente/no_image.png', 20),
(167, 'Arroz Basmati', '../css/img/ingrediente/no_image.png', 20),
(168, 'Arroz Branco', '../css/img/ingrediente/no_image.png', 20),
(170, 'Arroz Cateto', '../css/img/ingrediente/no_image.png', 20),
(171, 'Arroz Integral', '../css/img/ingrediente/no_image.png', 20),
(172, 'Arroz Japonês', '../css/img/ingrediente/no_image.png', 20),
(173, 'Arroz Jasmim', '../css/img/ingrediente/no_image.png', 20),
(174, 'Arroz Negro', '../css/img/ingrediente/no_image.png', 20),
(175, 'Arroz Parboilizado', '../css/img/ingrediente/no_image.png', 20),
(176, 'Arroz Selvagem', '../css/img/ingrediente/no_image.png', 20),
(177, 'Arroz Vermelho', '../css/img/ingrediente/no_image.png', 20),
(188, 'Leite', '../css/img/ingrediente/no_image.png', 8),
(189, 'Azeite', '../css/img/ingrediente/no_image.png', 1),
(190, 'Pimenta-do-reino', '../css/img/ingrediente/no_image.png', 1),
(191, 'Alface', '../css/img/ingrediente/no_image.png', 2),
(192, 'Espinafre', '../css/img/ingrediente/no_image.png', 2),
(193, 'Rúcula', '../css/img/ingrediente/no_image.png', 2),
(194, 'Couve', '../css/img/ingrediente/no_image.png', 2),
(195, 'Brócolis', '../css/img/ingrediente/no_image.png', 2),
(196, 'Cenoura', '../css/img/ingrediente/no_image.png', 2),
(197, 'Batata', '../css/img/ingrediente/no_image.png', 2),
(198, 'Cebola', '../css/img/ingrediente/no_image.png', 2),
(199, 'Alho-poró', '../css/img/ingrediente/no_image.png', 2),
(200, 'Champignon', '../css/img/ingrediente/no_image.png', 3),
(201, 'Shitake', '../css/img/ingrediente/no_image.png', 3),
(202, 'Funghi secchi', '../css/img/ingrediente/no_image.png', 3),
(203, 'Geleia de Morango', '../css/img/ingrediente/no_image.png', 5),
(204, 'Geleia de Damasco', '../css/img/ingrediente/no_image.png', 5),
(205, 'Frutas Cristalizadas', '../css/img/ingrediente/no_image.png', 5),
(206, 'Nozes', '../css/img/ingrediente/no_image.png', 6),
(207, 'Amêndoas', '../css/img/ingrediente/no_image.png', 6),
(208, 'Damasco Seco', '../css/img/ingrediente/no_image.png', 6),
(209, 'Uvas Passas', '../css/img/ingrediente/no_image.png', 6),
(210, 'Queijo Mussarela', '../css/img/ingrediente/no_image.png', 7),
(211, 'Queijo Parmesão', '../css/img/ingrediente/no_image.png', 7),
(212, 'Queijo Gouda', '../css/img/ingrediente/no_image.png', 7),
(213, 'Queijo Brie', '../css/img/ingrediente/no_image.png', 7),
(214, 'Queijo Gorgonzola', '../css/img/ingrediente/no_image.png', 7),
(215, 'Manteiga', '../css/img/ingrediente/no_image.png', 8),
(216, 'Iogurte Natural', '../css/img/ingrediente/no_image.png', 8),
(217, 'Tofu', '../css/img/ingrediente/no_image.png', 9),
(218, 'Proteína de Soja', '../css/img/ingrediente/no_image.png', 9),
(219, 'Leite de Amêndoas', '../css/img/ingrediente/no_image.png', 9),
(220, 'Presunto', '../css/img/ingrediente/no_image.png', 10),
(221, 'Salame', '../css/img/ingrediente/no_image.png', 10),
(222, 'Peito de Peru', '../css/img/ingrediente/no_image.png', 10),
(223, 'Patinho', '../css/img/ingrediente/no_image.png', 11),
(224, 'Alcatra', '../css/img/ingrediente/no_image.png', 11),
(225, 'Filé Mignon', '../css/img/ingrediente/no_image.png', 11),
(226, 'Lombo', '../css/img/ingrediente/no_image.png', 11),
(227, 'Pernil', '../css/img/ingrediente/no_image.png', 11),
(228, 'Peito de Frango', '../css/img/ingrediente/no_image.png', 12),
(229, 'Coxa de Frango', '../css/img/ingrediente/no_image.png', 12),
(230, 'Sobrecoxa de Frango', '../css/img/ingrediente/no_image.png', 12),
(231, 'Salmão', '../css/img/ingrediente/no_image.png', 13),
(232, 'Atum', '../css/img/ingrediente/no_image.png', 13),
(233, 'Bacalhau', '../css/img/ingrediente/no_image.png', 13),
(234, 'Camarão', '../css/img/ingrediente/no_image.png', 14),
(235, 'Lula', '../css/img/ingrediente/no_image.png', 14),
(236, 'Mexilhão', '../css/img/ingrediente/no_image.png', 14),
(237, 'Lagosta', '../css/img/ingrediente/no_image.png', 14),
(238, 'Cúrcuma', '../css/img/ingrediente/no_image.png', 15),
(239, 'Cominho', '../css/img/ingrediente/no_image.png', 15),
(240, 'Coentro', '../css/img/ingrediente/no_image.png', 15),
(241, 'Páprica', '../css/img/ingrediente/no_image.png', 15),
(242, 'Gengibre', '../css/img/ingrediente/no_image.png', 15),
(243, 'Mel', '../css/img/ingrediente/no_image.png', 16),
(244, 'Adoçante', '../css/img/ingrediente/no_image.png', 16),
(245, 'Xarope de Bordo', '../css/img/ingrediente/no_image.png', 16),
(246, 'Pimenta Jalapeño', '../css/img/ingrediente/no_image.png', 17),
(247, 'Pimenta Dedo-de-moça', '../css/img/ingrediente/no_image.png', 17),
(248, 'Pimenta Malagueta', '../css/img/ingrediente/no_image.png', 17),
(249, 'Capuchinha', '../css/img/ingrediente/no_image.png', 18),
(250, 'Flor de Hibisco', '../css/img/ingrediente/no_image.png', 18),
(251, 'Lavanda', '../css/img/ingrediente/no_image.png', 18),
(252, 'Farinha de Trigo', '../css/img/ingrediente/no_image.png', 19),
(253, 'Fermento Químico', '../css/img/ingrediente/no_image.png', 19),
(254, 'Farinha de Rosca', '../css/img/ingrediente/no_image.png', 19),
(255, 'Fermento Biológico', '../css/img/ingrediente/no_image.png', 19),
(256, 'Feijão', '../css/img/ingrediente/no_image.png', 20),
(257, 'Lentilha', '../css/img/ingrediente/no_image.png', 20),
(258, 'Quinoa', '../css/img/ingrediente/no_image.png', 20),
(259, 'Sementes de Girassol', '../css/img/ingrediente/no_image.png', 20),
(260, 'Linhaça', '../css/img/ingrediente/no_image.png', 20),
(261, 'Macarrão Espaguete', '../css/img/ingrediente/no_image.png', 21),
(262, 'Macarrão Penne', '../css/img/ingrediente/no_image.png', 21),
(263, 'Macarrão (Em Geral)', '../css/img/ingrediente/no_image.png', 21),
(264, 'Talharim', '../css/img/ingrediente/no_image.png', 21),
(265, 'Óleo de Girassol', '../css/img/ingrediente/no_image.png', 22),
(266, 'Azeite de Oliva', '../css/img/ingrediente/no_image.png', 22),
(267, 'Vinagre Balsâmico', '../css/img/ingrediente/no_image.png', 22),
(268, 'Vinagre de Maçã', '../css/img/ingrediente/no_image.png', 22),
(269, 'Banha de Porco', '../css/img/ingrediente/no_image.png', 22),
(270, 'Milho em Conserva', '../css/img/ingrediente/no_image.png', 23),
(271, 'Pepino em Conserva', '../css/img/ingrediente/no_image.png', 23),
(272, 'Azeitona', '../css/img/ingrediente/no_image.png', 23),
(273, 'Palmito', '../css/img/ingrediente/no_image.png', 23),
(274, 'Molho de Tomate', '../css/img/ingrediente/no_image.png', 24),
(275, 'Ketchup', '../css/img/ingrediente/no_image.png', 24),
(276, 'Mostarda', '../css/img/ingrediente/no_image.png', 24),
(277, 'Maionese', '../css/img/ingrediente/no_image.png', 24),
(278, 'Molho de soja / Molho Shoyu', '../css/img/ingrediente/no_image.png', 24),
(279, 'Caldo de Legumes', '../css/img/ingrediente/no_image.png', 25),
(280, 'Caldo de Galinha', '../css/img/ingrediente/no_image.png', 25),
(281, 'Caldo de Carde', '../css/img/ingrediente/no_image.png', 25),
(282, 'Sopa de Cebola', '../css/img/ingrediente/no_image.png', 25),
(283, 'Chocolate', '../css/img/ingrediente/no_image.png', 26),
(284, 'Biscoitos', '../css/img/ingrediente/no_image.png', 26),
(285, 'Pipoca de Microondas', '../css/img/ingrediente/no_image.png', 26),
(287, 'Pipoca de Microondas Sabor Manteiga', '../css/img/ingrediente/no_image.png', 26),
(288, 'Pão Francês', '../css/img/ingrediente/no_image.png', 29),
(289, 'Pão de Forma', '../css/img/ingrediente/no_image.png', 29),
(290, 'Croissant', '../css/img/ingrediente/no_image.png', 29),
(291, 'Pão Integral', '../css/img/ingrediente/no_image.png', 29);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `ingrediente_quantidade`
--

INSERT INTO `ingrediente_quantidade` (`id_ingrediente_quantidade`, `nome_singular_ingrediente_quantidade`, `nome_plural_ingrediente_quantidade`) VALUES
(20, '1/2 xícara de chá', '1/2 xícaras de chá'),
(24, '1/3 xícara de chá', '1/3 xícaras de chá'),
(21, '1/4 xícara de chá', '1/4 xícaras de chá'),
(23, '1/8 xícara de chá', '1/8 xícaras de chá'),
(25, '2/3 xícara de chá', '2/3 xícaras de chá'),
(22, '3/4 xícara de chá', '3/4 xícaras de chá'),
(1, 'a gosto', 'a gosto'),
(12, 'colher de café', 'colheres de café'),
(13, 'colher de chá', 'colheres de chá'),
(14, 'colher de sobremesa', 'colheres de sobremesa'),
(15, 'colher de sopa', 'colheres de sopa'),
(9, 'copo', 'copos'),
(16, 'copo americano', 'copos americanos'),
(17, 'copo requeijão', 'copos de requeijão'),
(4, 'fatia', 'fatias'),
(7, 'grama', 'gramas'),
(10, 'litro', 'litros'),
(11, 'mililitro', 'mililitros'),
(18, 'pacote', 'pacotes'),
(2, 'pedaço', 'pedaços'),
(5, 'pitada', 'pitadas'),
(3, 'punhado', 'punhados'),
(6, 'quilo', 'quilos'),
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
  KEY `FK_lista_de_ingredientes_1` (`fk_id_receita`),
  KEY `FK_lista_de_ingredientes_2` (`fk_id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `lista_de_ingredientes`
--

INSERT INTO `lista_de_ingredientes` (`fk_id_receita`, `fk_id_ingrediente`, `qtdIngrediente_lista`, `tipoQtdIngrediente_lista`) VALUES
(217, 94, 2.500, 0),
(218, 17, 2.000, 0),
(219, 17, 2.000, 0),
(220, 1, 1.000, 0),
(221, 110, 1.000, 0),
(221, 111, 1.000, 0),
(222, 110, 1.000, 0),
(222, 111, 1.000, 0),
(223, 111, 1.000, 0),
(224, 111, 1.000, 0),
(225, 113, 1.000, 22),
(225, 111, 4.000, 17),
(226, 110, 7.000, 15),
(234, 113, 1.000, 2),
(235, 52, 1.002, 22),
(236, 52, 1.002, 22),
(237, 52, 1.002, 22),
(263, 112, 1.000, 2),
(263, 95, 0.500, 19),
(264, 112, 1.000, 2),
(264, 95, 0.500, 19),
(265, 112, 1.000, 2),
(265, 95, 0.500, 19),
(266, 94, 1.000, 25),
(266, 114, 2.000, 9),
(266, 48, 3.000, 4),
(266, 113, 6.000, 5),
(267, 94, 1.000, 2),
(267, 114, 2.000, 2),
(267, 48, 3.000, 2),
(267, 113, 6.000, 2),
(268, 94, 1.000, 2),
(268, 114, 2.000, 2),
(268, 48, 3.000, 2),
(268, 113, 6.000, 2),
(269, 94, 1.000, 2),
(269, 114, 2.000, 2),
(269, 48, 3.000, 2),
(269, 113, 6.000, 2),
(270, 96, 1.000, 16),
(270, 13, 2.000, 17),
(271, 3, 1.002, 25),
(271, 18, 3.500, 25),
(272, 18, 1.005, 11),
(273, 18, 1.005, 11),
(274, 18, 1.005, 11);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `imagem_receita` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria_receita` int DEFAULT NULL,
  PRIMARY KEY (`id_receita`),
  KEY `fk_tipoPorcao` (`tipoPorcao_receita`)
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `receita`
--

INSERT INTO `receita` (`id_receita`, `nome_receita`, `numeroPorcao_receita`, `tipoPorcao_receita`, `tempoPreparoHora_receita`, `tempoPreparoMinuto_receita`, `modoPreparo_receita`, `imagem_receita`, `categoria_receita`) VALUES
(232, 'zzzzzzzzzzzz', 1.000, 1, 0, 1, 'nnnnnnnnnnnnnnnnnnnnnnnnn', '', 0),
(233, 'zzzzzzzzzzzz', 1.000, 1, 0, 1, 'nnnnnnnnnnnnnnnnnnnnnnnnn', '', 0),
(234, 'zzzzzzzzzzzz', 1.000, 1, 1, 1, 'nnnnnnnnnnnnnnnnnnnnnnnnn', '../css/img/receita/Conceitual.png', 0),
(235, 'yttttt', 1.000, 10, 1, 1, 'mmmmmmmmmmm', '../css/img/receita/Conceitual.png', 0),
(236, 'yttttt', 1.000, 10, 1, 1, 'mmmmmmmmmmm', '../css/img/receita/Conceitual.png', 0),
(237, 'yttttt', 1.000, 10, 1, 1, 'mmmmmmmmmmm', '../css/img/receita/Conceitual.png', 0),
(238, 'aaaaaaaaaaaaaa', 1.003, 1, 1, 0, 'aaaaaaaaaaaaaa', '', 0),
(239, '06/09', 1.003, 1, 1, 0, 'aaaaaaaaaaaaaa', '', 0),
(240, '06/09', 1.003, 1, 1, 1, 'aaaaaaaaaaaaaa', '', 0),
(241, '06/09', 1.003, 1, 0, 61, 'aaaaaaaaaaaaaa', '', 0),
(242, '06/09', 1.003, 2, 1, 59, 'aaaaaaaaaaaaaa', '', 0),
(243, '06/09', 1.003, 2, 1, 59, 'aaaaaaaaaaaaaa', '', 0),
(244, 'aaaaaaaaaaaaaaa', 1.006, 9, 0, 1, 'ggggggggggg', '', 0),
(245, 'aaaaaaaaaaaaaaa', 1.006, 9, 0, 1, 'ggggggggggg', '', 0),
(246, 'nnnnnnnnn', 1.000, 3, 0, 4, 'sssssssssss', '', 0),
(248, 'amanda', 1.000, 7, 0, 1, 'fffffffffffffffff', '', 0),
(249, 'amanda', 1.000, 7, 89, 1, 'fffffffffffffffff', '', 0),
(250, 'amanda', 1.000, 7, 89, 1, 'fffffffffffffffff', '../css/img/receita/bolo-de-cenoura.png', 0),
(251, 'amanda', 1.000, 7, 89, 1, 'fffffffffffffffff', '../css/img/receita/wepik-cute-pastel-purple-organizer-desktop-wallpaper-20240428185503qETJ.png', 0),
(252, 'amanda', 1.000, 7, 89, 1, 'fffffffffffffffff', '../css/img/receita/wepik-cute-pastel-purple-organizer-desktop-wallpaper-20240428185503qETJ.png', 0),
(253, 'amanda', 1.000, 7, 89, 1, 'fffffffffffffffff', '', 0),
(254, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', 0),
(255, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(256, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(257, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(258, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(259, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(260, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', NULL),
(261, 'ooooooooooooo', 1.000, 2, 1, 1, '´pppppppppppppppppp', '', 1),
(262, '444444444444', 5.000, 11, 2, 2, '´pppppppppppppppppp', '../css/img/receita/Sem título.png', 10),
(263, 'zzzzzzzzzzzzz', 1.000, 5, 0, 1, 'zzzzzzzzzzz', '', 9),
(264, 'zzzzzzzzzzzzz', 1.000, 5, 0, 1, 'zzzzzzzzzzz', '', 9),
(265, 'zzzzzzzzzzzzz', 1.000, 5, 0, 1, 'zzzzzzzzzzz', '', 9),
(266, '08/09', 1.000, 12, 1, 1, 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '../css/img/receita/wepik-cute-pastel-purple-organizer-desktop-wallpaper-20240428185503qETJ.png', 1),
(267, '08/09', 1.000, 12, 1, 1, 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '', 16),
(268, '08/09', 1.000, 12, 1, 1, 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '', 1),
(269, '08/09', 2.000, 12, 1, 1, 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '', 1),
(270, '17/09', 5.000, 5, 7, 10, '17/09', '../css/img/receita/bolo-de-cenoura.png', 6),
(271, 'AAAA', 1.000, 6, 0, 1, 'AAAAAAAAAAAAA', '', 6),
(272, 'Nome da Receita', 2.000, 6, 1, 1, 'Modo de Preparo', '../css/img/receita/CSU006 – Diagrama de Classes de Projeto por Caso de Uso.png', 11),
(273, 'Nome da Receita', 2.000, 6, 1, 1, 'Modo de Preparo', '../css/img/receita/CSU006 – Diagrama de Classes de Projeto por Caso de Uso.png', 11),
(274, 'Nome da Receita', 2.000, 6, 1, 1, 'Modo de Preparo', '../css/img/receita/CSU006 – Diagrama de Classes de Projeto por Caso de Uso.png', 11),
(275, '22/09', 1.234, 10, 1, 1, '22/09', '', 0),
(276, '22/09', 1.234, 10, 50, 50, '22/09', '', 0),
(277, '22/09', 1.234, 10, 50, 50, '22/09', '', 0),
(278, '22/09', 1.234, 10, 50, 50, '22/09', '', 0),
(279, '22/09', 1.234, 10, 50, 50, '22/09', '', 0),
(280, '22/09', 1.234, 10, 50, 50, '22/09', '', 0),
(281, '22/09imagem', 1.234, 10, 50, 50, '22/09', '', 0),
(282, '22/09imagem', 1.234, 10, 50, 50, '22/09', '../css/img/receita/Captura de tela 2024-09-16 170631.png', 0),
(283, '22/09imagem', 1.234, 10, 50, 50, '22/09', '', 0),
(284, '22/09imagem', 1.234, 10, 50, 59, '22/09', '', 12);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `imagem_usuario` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `statusAdministrador_usuario` char(1) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `unique_nome_usuario` (`nome_usuario`),
  UNIQUE KEY `unique_email_usuario` (`email_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `recuperar_senha`, `imagem_usuario`, `statusAdministrador_usuario`) VALUES
(150, 'Amanda', 'amanda@amanda.com', '$2y$10$LZizzKhOKDamLUPvIFwS7.9jAYYJ2rcMq8SZpTnTNPbToAYlTGK8m', NULL, '', ''),
(151, 'Amanda25/08', 'Amanda25/08@Amanda2508.com', '$2y$10$kbXYUO/.XU7v13RyQrGQoOheyTxpoxYZDv43wJMkW.msaSrzXUFwe', NULL, '', ''),
(152, 'teste', 'U@U.COM', '$2y$10$o7J99AMOXXYdwzBmDzPVcuXdo3FWKXD0A/NY0lCdZ3liEWDc3WHNa', NULL, 'css/img/usuario/Foto 3x4.jpg', ''),
(153, 'Yi', 'A@A.COM', '$2y$10$2.pC62x8hjauus9gishhO.w3VU0B33c7WsvagmdSsP/wbShujY/ny', NULL, 'css/img/usuario/Foto 3x4.jpg', ''),
(154, 'E@E.COM', 'E@E.COM', '$2y$10$DDdX1hDEROqyWW.ijuaXgOh3XLb.mITfQUJTaGmsZed8q1s0LlOVK', NULL, '', ''),
(155, 'alterado7', 'r@r.com', '$2y$10$UKxOHnaceMbblPK.dBujDOlWG6KA3zqA7DTn8wK7.KEt.z3N3wI3e', NULL, 'css/img/usuario/Foto 3x4.jpg', ''),
(156, '77777@5.com', '77777@5.com', '$2y$10$fYUZE8QKGrBasT5woJD2Aumiw.dvwnAyNRe6nHlA43MqMS11HSg/e', NULL, '', ''),
(157, '7', 'A17/08@gmail.com', '$2y$10$Q9gIEwLYGOKh7u2OQECvBuHAQAqlimfQ6mF8IHSVbzA.uG4M59sJ6', NULL, 'css/img/usuario/creme-da-novica.jpg', ''),
(158, '20/09@gmail.com', '20/09@gmail.com', '$2y$10$P0jeNV3nsSJCkQTqGZV08.PAr5SFEglXQHQczflBxmodwQFtAzUAm', NULL, '', '');

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
-- Restrições para tabelas `receita`
--
ALTER TABLE `receita`
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
