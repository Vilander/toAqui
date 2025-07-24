-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/07/2025 às 01:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `quadro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `categoria` varchar(50) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `email`, `telefone`, `categoria`, `produto`, `descricao`, `link`, `imagem`, `criado_em`) VALUES
(1, 'teste', 'email@email.com', '19999999999', 'moda', 'cupcake mariana', 'bolos no pote e afins', 'https://www.instagram.com', 'uploads/img_68816639d7a153.53332244.jpg', '2025-07-23 22:46:17'),
(2, 'roberto', 'roberto@senac.com', '1999999998', 'domesticos', 'Faxineiro', 'faço limpeza', '', NULL, '2025-07-23 22:56:00'),
(3, 'Vitor', 'vitor@vitor.com', '179999999999', 'eventos', 'festas', 'faço eventos', 'https://www.instagram.com', 'uploads/img_6881691743c158.26783047.png', '2025-07-23 22:58:31'),
(4, 'samuel', 'samuel@samuel', '119999999', 'pets', 'Banho e tosa', 'serviço de banho de tosa', 'https://www.instagram.com', 'imagens/no-image.png', '2025-07-23 23:04:40'),
(5, 'VILANDER ADALBERTO DA SILVA COSTA', 'vilander.costa@gmail.com', '199999999', 'eletronicos', 'Lojinha de capinha', 'Capinha de aifone', 'https://www.instagram.com', 'imagens/no-image.png', '2025-07-23 23:07:32');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
