-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Fev-2019 às 00:22
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uemg_eventos`
--
CREATE DATABASE IF NOT EXISTS `uemg_eventos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `uemg_eventos`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `id` int(11) NOT NULL,
  `titulo` varchar(90) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `vagas_total` int(11) NOT NULL,
  `vagas_disp` int(11) NOT NULL,
  `ministrante` varchar(40) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fim` time DEFAULT NULL,
  `local_atividade` varchar(50) DEFAULT NULL,
  `img` longtext NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_evento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `certificados`
--

CREATE TABLE `certificados` (
  `id` int(14) NOT NULL,
  `evento` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL
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
  `valor` varchar(17) DEFAULT NULL,
  `pagar_para` varchar(45) DEFAULT NULL,
  `banner` longtext NOT NULL,
  `status` varchar(11) DEFAULT NULL,
  `id_local` int(11) NOT NULL,
  `edital` tinyint(1) NOT NULL,
  `arquivo_edital` longtext,
  `submissao_projeto` tinyint(1) NOT NULL,
  `certificado` tinyint(1) NOT NULL,
  `regra` double DEFAULT NULL,
  `adm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_pago`
--

CREATE TABLE `evento_pago` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  `pagamento` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais`
--

CREATE TABLE `locais` (
  `id` int(11) NOT NULL,
  `local` varchar(65) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `evento` int(11) NOT NULL,
  `nome` longtext CHARACTER SET utf8 NOT NULL,
  `data_hora` datetime NOT NULL,
  `aprovacao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `requisitar_senha`
--

CREATE TABLE `requisitar_senha` (
  `id` int(11) NOT NULL,
  `email` varchar(225) CHARACTER SET utf8 NOT NULL,
  `data` datetime NOT NULL,
  `token` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `suporte`
--

CREATE TABLE `suporte` (
  `id` int(11) NOT NULL,
  `nome` varchar(36) CHARACTER SET utf8 NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `assunto` varchar(45) CHARACTER SET utf8 NOT NULL,
  `mensagem` varchar(1000) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(62) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `ra` varchar(45) DEFAULT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(17) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `instituicao` varchar(45) DEFAULT NULL,
  `adm` tinyint(1) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `img_perfil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_atividade`
--

CREATE TABLE `usuario_atividade` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `atividade` int(11) NOT NULL,
  `presenca` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_certificado_evento` (`evento`),
  ADD KEY `fk_certificado_usuario` (`usuario`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_local` (`id_local`);

--
-- Indexes for table `evento_pago`
--
ALTER TABLE `evento_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento` (`evento`),
  ADD KEY `fk_usuario` (`usuario`);

--
-- Indexes for table `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_projeto` (`usuario`),
  ADD KEY `fk_evento_projeto` (`evento`);

--
-- Indexes for table `requisitar_senha`
--
ALTER TABLE `requisitar_senha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suporte`
--
ALTER TABLE `suporte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_cursos1_idx` (`id_curso`);

--
-- Indexes for table `usuario_atividade`
--
ALTER TABLE `usuario_atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atividade` (`atividade`),
  ADD KEY `fk_user` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evento_pago`
--
ALTER TABLE `evento_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locais`
--
ALTER TABLE `locais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suporte`
--
ALTER TABLE `suporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario_atividade`
--
ALTER TABLE `usuario_atividade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Limitadores para a tabela `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `fk_certificado_evento` FOREIGN KEY (`evento`) REFERENCES `eventos` (`id`),
  ADD CONSTRAINT `fk_certificado_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_local` FOREIGN KEY (`id_local`) REFERENCES `locais` (`id`);

--
-- Limitadores para a tabela `evento_pago`
--
ALTER TABLE `evento_pago`
  ADD CONSTRAINT `fk_evento` FOREIGN KEY (`evento`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `fk_evento_projeto` FOREIGN KEY (`evento`) REFERENCES `eventos` (`id`),
  ADD CONSTRAINT `fk_user_projeto` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
