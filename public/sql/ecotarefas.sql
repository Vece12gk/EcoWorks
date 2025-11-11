-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/11/2025 às 02:26
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
-- Banco de dados: `ecotarefas`
--
CREATE DATABASE IF NOT EXISTS `ecotarefas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ecotarefas`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico`
--

CREATE TABLE `historico` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_missao` int(11) NOT NULL,
  `data_conclusao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `missoes`
--

CREATE TABLE `missoes` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `pontos` int(11) DEFAULT 0,
  `impacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `missoes`
--

INSERT INTO `missoes` (`id`, `descricao`, `pontos`, `impacto`) VALUES
(1, 'Desligar as luzes de cômodos que não estão sendo usados', 10, 'Baixo'),
(2, 'Separar o lixo reciclável corretamente', 20, 'Médio'),
(3, 'Evitar o uso de copos descartáveis no dia', 15, 'Médio'),
(4, 'Plantar uma muda de árvore ou flor', 40, 'Alto'),
(5, 'Economizar água durante o banho (menos de 5 minutos)', 20, 'Médio'),
(6, 'Levar uma sacola reutilizável ao mercado', 15, 'Baixo'),
(7, 'Desligar o carregador do celular após carregar completamente', 10, 'Baixo'),
(8, 'Apagar todos os aparelhos eletrônicos da tomada ao sair de casa', 25, 'Médio'),
(9, 'Utilizar transporte público, bicicleta ou caminhar ao invés do carro', 30, 'Alto'),
(10, 'Ensinar alguém a fazer separação do lixo', 25, 'Médio'),
(11, 'Reutilizar garrafas ou potes plásticos em casa', 15, 'Baixo'),
(12, 'Evitar imprimir papéis desnecessariamente', 10, 'Baixo'),
(13, 'Participar de uma coleta de lixo comunitária', 40, 'Alto'),
(14, 'Fazer compostagem com restos de alimentos', 35, 'Alto'),
(15, 'Economizar energia reduzindo o uso do ar-condicionado', 25, 'Médio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ranking`
--

CREATE TABLE `ranking` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `pontos` int(11) DEFAULT 0,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `pontos` int(11) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `pontos`, `data_criacao`) VALUES
(1, 'Natan', 'natanvee_@hotmail.com', '$2y$10$HBEGrQ/f5xghjnMaorvgXuchUtK7wVtC7IUricsOzuS3wM3WxKd7u', 110, '2025-11-08 20:07:39'),
(2, 'a', 'usuario@exemplo.com', '$2y$10$W7ycwLSXpE1aEHQfTorcu./XLQrkLydmZy2SOp1pLpivV4yeqlLyG', 60, '2025-11-08 23:05:08'),
(3, 'a', 'aaa@hotmail.com', '$2y$10$fWQ3Hc4Dbi/JOAPnEcNWFu1YQKTPyQYTSqMBi1thTq/6PSY8fZZSC', 0, '2025-11-11 01:07:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_missoes`
--

CREATE TABLE `usuario_missoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `missoes_id` int(11) NOT NULL,
  `pendencia` varchar(10) NOT NULL,
  `data_mis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_missoes`
--

INSERT INTO `usuario_missoes` (`id`, `usuario_id`, `missoes_id`, `pendencia`, `data_mis`) VALUES
(2, 1, 7, 'concluida', '2025-11-08'),
(8, 1, 7, 'concluida', '2025-11-08'),
(14, 1, 7, 'concluida', '2025-11-08'),
(20, 1, 7, 'concluida', '2025-11-08'),
(26, 1, 7, 'concluida', '2025-11-08'),
(27, 1, 10, 'concluida', '2025-11-08'),
(28, 1, 13, 'concluida', '2025-11-08'),
(29, 1, 12, 'concluida', '2025-11-08'),
(30, 1, 11, 'concluida', '2025-11-08'),
(31, 1, 6, 'concluida', '2025-11-08'),
(32, 1, 7, 'concluida', '2025-11-08'),
(33, 1, 10, 'concluida', '2025-11-08'),
(34, 1, 13, 'concluida', '2025-11-08'),
(35, 1, 12, 'concluida', '2025-11-08'),
(36, 1, 11, 'concluida', '2025-11-08'),
(37, 1, 6, 'concluida', '2025-11-08'),
(38, 1, 7, 'concluida', '2025-11-08'),
(39, 1, 10, 'concluida', '2025-11-08'),
(40, 1, 13, 'concluida', '2025-11-08'),
(41, 1, 12, 'concluida', '2025-11-08'),
(42, 1, 11, 'concluida', '2025-11-08'),
(43, 1, 6, 'concluida', '2025-11-08'),
(44, 1, 7, 'concluida', '2025-11-08'),
(45, 1, 10, 'concluida', '2025-11-08'),
(46, 1, 13, 'concluida', '2025-11-08'),
(47, 1, 12, 'concluida', '2025-11-08'),
(48, 1, 11, 'concluida', '2025-11-08'),
(49, 1, 6, 'concluida', '2025-11-08'),
(50, 1, 6, 'concluida', '2025-11-08'),
(51, 1, 6, 'concluida', '2025-11-08'),
(52, 1, 6, 'concluida', '2025-11-08'),
(53, 1, 6, 'concluida', '2025-11-08'),
(54, 1, 6, 'concluida', '2025-11-08'),
(55, 1, 6, 'concluida', '2025-11-08'),
(56, 1, 6, 'concluida', '2025-11-08'),
(57, 1, 7, 'concluida', '2025-11-08'),
(58, 1, 7, 'concluida', '2025-11-08'),
(59, 1, 7, 'concluida', '2025-11-08'),
(60, 1, 7, 'concluida', '2025-11-08'),
(61, 1, 7, 'concluida', '2025-11-08'),
(62, 1, 7, 'concluida', '2025-11-08'),
(63, 1, 7, 'concluida', '2025-11-08'),
(64, 1, 7, 'concluida', '2025-11-08'),
(65, 1, 10, 'concluida', '2025-11-08'),
(66, 1, 10, 'concluida', '2025-11-08'),
(67, 1, 10, 'concluida', '2025-11-08'),
(68, 1, 10, 'concluida', '2025-11-08'),
(69, 1, 10, 'concluida', '2025-11-08'),
(70, 1, 10, 'concluida', '2025-11-08'),
(71, 1, 10, 'concluida', '2025-11-08'),
(97, 2, 4, 'concluida', '2025-11-08'),
(98, 2, 9, 'concluida', '2025-11-08'),
(99, 2, 13, 'concluida', '2025-11-08'),
(100, 1, 15, 'concluida', '2025-11-09'),
(101, 1, 9, 'concluida', '2025-11-09'),
(102, 1, 13, 'concluida', '2025-11-09'),
(103, 2, 11, 'concluida', '2025-11-09'),
(104, 2, 8, 'concluida', '2025-11-09'),
(105, 2, 4, 'concluida', '2025-11-09'),
(106, 1, 8, 'pendente', '2025-11-10'),
(107, 1, 3, 'pendente', '2025-11-10'),
(108, 1, 1, 'pendente', '2025-11-10');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_missao` (`id_missao`);

--
-- Índices de tabela `missoes`
--
ALTER TABLE `missoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuario_missoes`
--
ALTER TABLE `usuario_missoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `missoes_id` (`missoes_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `missoes`
--
ALTER TABLE `missoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `ranking`
--
ALTER TABLE `ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario_missoes`
--
ALTER TABLE `usuario_missoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `fk_historico_missao` FOREIGN KEY (`id_missao`) REFERENCES `missoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historico_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_missoes`
--
ALTER TABLE `usuario_missoes`
  ADD CONSTRAINT `usuario_missoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuario_missoes_ibfk_2` FOREIGN KEY (`missoes_id`) REFERENCES `missoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

