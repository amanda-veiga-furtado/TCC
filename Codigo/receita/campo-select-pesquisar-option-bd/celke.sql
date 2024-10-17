-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 15-Out-2022 às 20:15
-- Versão do servidor: 8.0.27
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `celke`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id`, `usuario_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ingrediente`
--

DROP TABLE IF EXISTS `ingrediente`;
CREATE TABLE IF NOT EXISTS `ingrediente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_ingrediente` int NOT NULL,
  `produto_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `ingrediente`
--

INSERT INTO `ingrediente` (`id`, `id_ingrediente`, `produto_id`) VALUES
(1, 1, 3),
(2, 1, 12),
(3, 1, 2),
(4, 1, 19),
(5, 1, 4),
(6, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`) VALUES
(1, 'Teclado A'),
(2, 'Notebook Samsung'),
(3, 'Notebook Dell'),
(4, 'Notebook Vaio'),
(5, 'Notebook Lenovo'),
(6, 'Notebook Gamer'),
(7, 'MacBook Pro'),
(8, 'Monitor Gamer'),
(9, 'Monitor para PC'),
(10, 'Impressora Multifuncional Epson'),
(11, 'Impressora Multifuncional HP'),
(12, 'Impressora Térmica Não Fiscal'),
(13, 'Roteador TP-Link'),
(14, 'Roteador Repetidor De Sinal'),
(15, 'Switch 8 Portas'),
(16, 'Nintendo Switch Lite '),
(17, 'Nintendo Switch Mario Kart 8'),
(18, 'Mouse sem Fio Movitec Óptico'),
(19, 'Mouse Multilaser Sem Fio'),
(20, 'Teclado Mecânico Gamer T-Dagger'),
(21, 'Teclado e Mouse Sem Fio Logitech'),
(22, 'Teclado Numérico Gamer USB Multilaser Hotkeys Slim'),
(23, 'Carteira Bitcoin Trezor One Wallet'),
(24, 'Carteira De Criptomoedas Ledger Nanos'),
(25, 'Mouse Gamer Redragon Cobra'),
(26, 'Mouse Gamer Razer Viper Mini');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_usuario`) VALUES
(1, 'Cesar'),
(2, 'Kelly'),
(3, 'Jessica'),
(4, 'Gabrielly');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
