-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 03-Mar-2020 às 06:14
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sistemaChat`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hb_name` varchar(18) NOT NULL COMMENT 'Nome do usuário.',
  `codigo_hb_name` varchar(21) NOT NULL COMMENT 'Ele é usado para a identificação de um usuário.',
  `nivel` int(11) NOT NULL DEFAULT '0' COMMENT 'Representa o nível de hierarquia interna que envolve a administração do sistema e respectivos recursos administrativos.',
  `criado_timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) COMMENT 'É gravado aqui a data e a hora em que o usuário passou a se tornar um Moderador,Administrador  do sistema. Aqui',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_hb_name` (`codigo_hb_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `amigos`
--

DROP TABLE IF EXISTS `amigos`;
CREATE TABLE IF NOT EXISTS `amigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `habbo_name` varchar(18) NOT NULL COMMENT 'Nome do Habbo do Usuário.',
  `codigo_hb_name` varchar(22) NOT NULL COMMENT 'O código de identificação do usuário no sistema.',
  `qtd_amigos` int(11) DEFAULT '0' COMMENT 'A quantidade de amigos já calculada pelo sistema. ',
  `amigos` varchar(1271) DEFAULT NULL COMMENT 'Aqui fica uma informação em JSON. Cujo possui uma matriz.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_hb_name` (`codigo_hb_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `autenticador_de_sessao`
--

DROP TABLE IF EXISTS `autenticador_de_sessao`;
CREATE TABLE IF NOT EXISTS `autenticador_de_sessao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `habbo_name` varchar(18) NOT NULL COMMENT 'É o nome Habbo que o usuário utilizou para a criação da conta.',
  `codigo_hb_name` varchar(22) NOT NULL COMMENT 'Código de identificação do usuário por todo a base de dados desse sistema.',
  `server` varchar(7) NOT NULL COMMENT 'O usuário que logou iniciou uma sessão em um respectivo servidor.',
  `session_code` varchar(32) NOT NULL COMMENT 'É o código da sessão. Ele é HASH da sessão. Ele fica no banco de dados para que o Administrador e Gerente Geral tenha mais controle sobre as sessão dos usuários.',
  `timestamp_criada` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) COMMENT 'Quando a sessão foi registrada no banco de dados. Normalmente o sistema cria a sessão após o login e a armazena no banco de dados.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `codigo_confirmacao`
--

DROP TABLE IF EXISTS `codigo_confirmacao`;
CREATE TABLE IF NOT EXISTS `codigo_confirmacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `habbo_name` varchar(18) NOT NULL COMMENT 'O nome do usuário é cadastrado. Porém ainda está em verificação. É neste processo que o sistema armazena o código mantendo sua relação com o nome apresentado/cadastrado pelo usuário. O sistema precisa cadastrar o nome. Porém num cadastro de verificação. Qualquer um pode sobreescrever os dados. Mas só  um pode confirmar utilizando o código correto.',
  `codigo_hb_name` varchar(20) DEFAULT NULL COMMENT 'Não sei porque eu inclui este campo nessa tabela que se trata de uma mera verificação. Por não se tratar de um cadastro do usuário de FATO no sistema o seu código de identificação não é gerado por isso não deveria nem existir este campo. Ainda não tenho certeza. Vou deixa-lo para no futuro eu compreender. ',
  `email` varchar(34) DEFAULT NULL COMMENT 'O campo está aí. Porém o usuário não precisa informar o seu email no seu cadastro para se cadastrar ao sistema NA VERSÂO BETA deste sistema. Mais pra frente posso tornar obrigatório o usuário ter de informar qual é o seu email. Por isso estou deixando este campo aqui porém NULO.',
  `codigo_email` int(6) NOT NULL,
  `status` int(11) DEFAULT '0',
  `criado_timestamp` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) COMMENT 'Quando o usuário cadastra esse é o seu primeiro registro. Seus dados ainda precisam ser confirmados.. o sistema precisa confirmar que é dele mesmo o email e nome de usuário no Habbo. Portanto o timestamp é gravado para a restauração dos códigos de verificação quando o seu tempo de verificação superior o tempo configurado no arquivo sistemaConfig.xml no diretório do sistema.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conversas`
--

DROP TABLE IF EXISTS `conversas`;
CREATE TABLE IF NOT EXISTS `conversas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` varchar(100) NOT NULL COMMENT 'Id do grupo',
  `criado_timestamp` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) COMMENT 'Data e hora de quando o bloco de conversa foi criado.',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `sequencia` varchar(3600) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grupo_id` (`grupo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `criador_id` varchar(24) NOT NULL COMMENT 'Id de identificação do indivíduo que criou o grupo.',
  `nome_grupo` varchar(30) NOT NULL,
  `criado_timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `participantes_id` varchar(1272) DEFAULT NULL,
  `theme` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `admins_do_grupo` varchar(1271) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`criador_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `habbo_name` varchar(18) NOT NULL COMMENT 'Nome do usuário cadastrado no sistema.',
  `senha` varchar(34) NOT NULL COMMENT 'Senha do usuário cadastrado. Vai es',
  `creditos` int(11) NOT NULL DEFAULT '0' COMMENT 'O crédito que o usário possui no sistema. Será usado para a utilização de funções no chat.',
  `email` varchar(34) DEFAULT NULL COMMENT 'O email que o usuário irá cadastrar/vincular a conta no sistema.',
  `celular` varchar(12) DEFAULT NULL COMMENT 'O número de celular do usuário que irá vincular a conta.',
  `rede_social` varchar(83) DEFAULT NULL,
  `criando_timestamp` timestamp(6) NOT NULL COMMENT 'É a hora e a data quando o usuário foi cadastrado no sistema.',
  `ban` tinyint(1) DEFAULT '0' COMMENT 'O usuário pode ser banido do sistema. Não há tempo de término para o banido. É necessário enviar um email para a administração do site ou sistema.',
  `server` varchar(7) NOT NULL DEFAULT '.com.br' COMMENT 'Indica em qual servidor o usuário pertence. No cadastra ele informará.',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Define se o usuário está online ou offline.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `habbo_name` (`habbo_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
