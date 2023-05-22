-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Maio-2023 às 22:46
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `trabalhotestes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `fk_topic` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `comment` varchar(256) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `comments`
--

INSERT INTO `comments` (`id`, `fk_topic`, `fk_user`, `comment`, `createdAt`, `updatedAt`) VALUES
(1, 1, 1, 'TESTE COMMENT', '2023-05-22 14:51:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `improvementsuggestions`
--

CREATE TABLE `improvementsuggestions` (
  `id` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `suggestion` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `improvementsuggestions`
--

INSERT INTO `improvementsuggestions` (`id`, `fk_user`, `suggestion`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'shmujk183m', '2023-05-22 20:38:05', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `keywords` varchar(256) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `topics`
--

INSERT INTO `topics` (`id`, `title`, `description`, `keywords`, `createdAt`, `updatedAt`) VALUES
(1, 'TOPIC 1', 'TESTE DESCRIPTION', 'TESTE;TESTE2', '2023-05-22 14:50:39', NULL),
(2, '111', '123', '123', '2023-05-22 18:43:56', NULL),
(3, 'h5nspnecdy', '90ez6fgpff', 'nw8pm0fg0i', '2023-05-22 18:44:10', NULL),
(4, '3j4ukw96eo', 'xeionvlxor', '76qqd5bezw', '2023-05-22 18:45:14', NULL),
(5, '4kfge5vaz9', 'pkdla0iw6t', 'akpv1zre38', '2023-05-22 18:46:25', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `permission` enum('admin','supervisor','common') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `createdAt`, `updatedAt`) VALUES
(1, 'admin', '$2y$10$OYB7Qe02EZvv6S8NeWbqDuUF7bxv2NvHDhNpEFZOe7JC1LPz8Wp0y', 'admin', '2023-05-22 00:49:23', NULL),
(49, '4dfbex92qq', '$2y$10$RVLmjXuuccQAo.9KlWTj1.PEh/fWY0NIbImTAyFUPhzeHEhRADG5G', 'supervisor', '2023-05-22 15:19:30', NULL),
(50, 'gustavosoares', '$2y$10$0UPlcThMY1X2gXfL26H6g.1ELsdRY5ArMqxp19gxMwYDnqwmkkGT6', 'supervisor', '2023-05-22 15:19:30', NULL),
(51, '6jemejyih1', '$2y$10$HvGe0WSbYOUlcd.pEBxlbenHJiBf/vw.glFAdiJabwWQPjz0Np6DW', 'supervisor', '2023-05-22 15:24:33', NULL),
(53, 'hi7ubzquq7', '$2y$10$CCmyA7Im3X4AFaTWaRRG5OGmGnBjn7p0pJpcgg/AJ78GPwTmNfPRi', 'supervisor', '2023-05-22 15:24:53', NULL),
(55, 'gustavo7', '$2y$10$u1fhFmiTErcO.so0M60KPuCsGb7MI8otp6ZhDCTDLWbXjClDjoIGm', 'common', '2023-05-22 15:49:26', NULL),
(56, 'sa9ad3fwvo', '$2y$10$2IB..yoAq7ZstKlSqhYuPemOhGEC0GtuuXHHHNAUpXvQFaX52RVPS', 'supervisor', '2023-05-22 16:02:15', '2023-05-22 13:02:16');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `fk_topic` (`fk_topic`);

--
-- Índices para tabela `improvementsuggestions`
--
ALTER TABLE `improvementsuggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Índices para tabela `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `improvementsuggestions`
--
ALTER TABLE `improvementsuggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`fk_topic`) REFERENCES `topics` (`id`);

--
-- Limitadores para a tabela `improvementsuggestions`
--
ALTER TABLE `improvementsuggestions`
  ADD CONSTRAINT `improvementsuggestions_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
