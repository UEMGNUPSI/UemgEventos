-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21-Mar-2017 às 19:04
-- Versão do servidor: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uemg_eventos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `id` int(11) NOT NULL,
  `titulo` varchar(90) NOT NULL,
  `descricao` varchar(99) DEFAULT NULL,
  `vagas_total` int(11) NOT NULL,
  `vagas_disp` int(11) NOT NULL,
  `ministrante` varchar(40) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fim` time DEFAULT NULL,
  `local_atividade` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_evento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atividades`
--

INSERT INTO `atividades` (`id`, `titulo`, `descricao`, `vagas_total`, `vagas_disp`, `ministrante`, `data_inicio`, `hora_inicio`, `hora_fim`, `local_atividade`, `id_categoria`, `id_evento`) VALUES
(3, 'Android Avançado II', 'Mini curso para aprendizado de endroid II', 30, 25, 'Professor de Android II', '2004-04-04', '12:40:00', '15:35:00', 'Laboratorio 5', 2, 11),
(6, 'atividade', 'descrição', 15, 14, 'ministrante', '0000-00-00', '14:14:00', '15:15:15', 'local', 1, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `titulo`) VALUES
(1, 'workshop'),
(2, 'mini curso');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`) VALUES
(2, 'SISTEMAS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_has_eventos`
--

CREATE TABLE `cursos_has_eventos` (
  `id_cursos` int(11) NOT NULL,
  `id_eventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` longtext NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `organizador` varchar(45) NOT NULL,
  `valor` float DEFAULT NULL,
  `pagar_para` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descricao`, `data_inicio`, `data_fim`, `organizador`, `valor`, `pagar_para`) VALUES
(11, 'Semana de Sistemas', 'Testando02', '2001-02-03', '2004-05-06', 'DA', 150, 'Junior'),
(12, 'Crisuf', 'Congresso Regional', '2017-03-22', '2011-11-11', 'Pesquisa e Extensao', 30, 'Empresa Junior'),
(13, 'rrrrrrrrr', 'rrrrrrrr', '2012-12-12', '2010-10-10', 'rrrrr', 15, 'rsdsrsrsrsrs');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `ra` varchar(45) DEFAULT NULL,
  `ano` int(4) DEFAULT NULL,
  `cpf` varchar(45) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `ra`, `ano`, `cpf`, `admin`, `id_curso`) VALUES
(1, 'teste', 'teste@teste.com', '698dc19d489c4e4db73e28a713eab07b', NULL, NULL, NULL, 1, NULL),
(2, 'nupsi', 'hehue@email.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_atividade` (`id_categoria`),
  ADD KEY `fk_evento_atividade` (`id_evento`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cursos_has_eventos`
--
ALTER TABLE `cursos_has_eventos`
  ADD PRIMARY KEY (`id_cursos`,`id_eventos`),
  ADD KEY `fk_cursos_has_eventos_eventos1_idx` (`id_eventos`),
  ADD KEY `fk_cursos_has_eventos_cursos1_idx` (`id_cursos`);

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_cursos1_idx` (`id_curso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `fk_categoria_atividade` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `fk_evento_atividade` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id`);

--
-- Limitadores para a tabela `cursos_has_eventos`
--
ALTER TABLE `cursos_has_eventos`
  ADD CONSTRAINT `fk_cursos_has_eventos_cursos1` FOREIGN KEY (`id_cursos`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cursos_has_eventos_eventos1` FOREIGN KEY (`id_eventos`) REFERENCES `eventos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
