-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para bdmovies
DROP DATABASE IF EXISTS `bdmovies`;
CREATE DATABASE IF NOT EXISTS `bdmovies` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bdmovies`;

-- A despejar estrutura para tabela bdmovies.cinema
DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `codigo` int(11) NOT NULL,
  `nome_cinema` varchar(100) NOT NULL,
  `telefone_cinema` int(11) NOT NULL,
  `morada_cinema` varchar(100) NOT NULL,
  `codPostal_cinema` varchar(50) NOT NULL DEFAULT '',
  `arruamento_cinema` int(11) NOT NULL,
  `localidade_cinema` varchar(100) NOT NULL,
  `dataInau_cinema` date NOT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.cinema: ~1 rows (aproximadamente)
DELETE FROM `cinema`;
INSERT INTO `cinema` (`codigo`, `nome_cinema`, `telefone_cinema`, `morada_cinema`, `codPostal_cinema`, `arruamento_cinema`, `localidade_cinema`, `dataInau_cinema`) VALUES
	(2121, 'nomecinema', 966555777, 'morada', '3333-555', 145, 'localidade', '2020-01-01');

-- A despejar estrutura para tabela bdmovies.classificacao
DROP TABLE IF EXISTS `classificacao`;
CREATE TABLE IF NOT EXISTS `classificacao` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.classificacao: ~3 rows (aproximadamente)
DELETE FROM `classificacao`;
INSERT INTO `classificacao` (`codigo`, `descricao`) VALUES
	(1, 'ruim'),
	(2, 'bom'),
	(3, 'muito bom');

-- A despejar estrutura para tabela bdmovies.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `numCliente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `morada` varchar(50) NOT NULL,
  `telefone` int(11) NOT NULL,
  PRIMARY KEY (`numCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.cliente: ~0 rows (aproximadamente)
DELETE FROM `cliente`;

-- A despejar estrutura para tabela bdmovies.empregado
DROP TABLE IF EXISTS `empregado`;
CREATE TABLE IF NOT EXISTS `empregado` (
  `bi` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `telefone` int(11) NOT NULL,
  `morada` varchar(100) NOT NULL,
  `codPostal` int(11) NOT NULL,
  `localidade` varchar(50) NOT NULL,
  `codTipoEmpregado` int(11) NOT NULL,
  PRIMARY KEY (`bi`),
  KEY `codTipoEmpregado` (`codTipoEmpregado`),
  CONSTRAINT `codTipoEmpregado` FOREIGN KEY (`codTipoEmpregado`) REFERENCES `tipoempregado` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.empregado: ~0 rows (aproximadamente)
DELETE FROM `empregado`;

-- A despejar estrutura para tabela bdmovies.filme
DROP TABLE IF EXISTS `filme`;
CREATE TABLE IF NOT EXISTS `filme` (
  `idImbd` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ano` varchar(50) NOT NULL DEFAULT '',
  `codigoClassificacao` int(11) NOT NULL,
  PRIMARY KEY (`idImbd`) USING BTREE,
  KEY `codigoClassificacao` (`codigoClassificacao`),
  CONSTRAINT `codigoClassificacao` FOREIGN KEY (`codigoClassificacao`) REFERENCES `classificacao` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.filme: ~0 rows (aproximadamente)
DELETE FROM `filme`;
INSERT INTO `filme` (`idImbd`, `nome`, `ano`, `codigoClassificacao`) VALUES
	(212, 'nomefilem', '2020', 2);

-- A despejar estrutura para tabela bdmovies.sala
DROP TABLE IF EXISTS `sala`;
CREATE TABLE IF NOT EXISTS `sala` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `numMax` int(11) NOT NULL,
  `codCinema` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `codCinema` (`codCinema`),
  CONSTRAINT `codCinema` FOREIGN KEY (`codCinema`) REFERENCES `cinema` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.sala: ~0 rows (aproximadamente)
DELETE FROM `sala`;

-- A despejar estrutura para tabela bdmovies.sessao
DROP TABLE IF EXISTS `sessao`;
CREATE TABLE IF NOT EXISTS `sessao` (
  `dataHora` datetime NOT NULL,
  `codigoSala` int(11) NOT NULL,
  `idImbdFilme` int(11) NOT NULL,
  KEY `codigoSala` (`codigoSala`),
  KEY `idImbdFilme` (`idImbdFilme`),
  CONSTRAINT `codigoSala` FOREIGN KEY (`codigoSala`) REFERENCES `cinema` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `idImbdFilme` FOREIGN KEY (`idImbdFilme`) REFERENCES `filme` (`idImbd`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.sessao: ~0 rows (aproximadamente)
DELETE FROM `sessao`;

-- A despejar estrutura para tabela bdmovies.tipoempregado
DROP TABLE IF EXISTS `tipoempregado`;
CREATE TABLE IF NOT EXISTS `tipoempregado` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.tipoempregado: ~0 rows (aproximadamente)
DELETE FROM `tipoempregado`;

-- A despejar estrutura para tabela bdmovies.tipouser
DROP TABLE IF EXISTS `tipouser`;
CREATE TABLE IF NOT EXISTS `tipouser` (
  `id_user` int(11) NOT NULL,
  `descricao_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.tipouser: ~2 rows (aproximadamente)
DELETE FROM `tipouser`;
INSERT INTO `tipouser` (`id_user`, `descricao_user`) VALUES
	(1, 'ADMIN'),
	(2, 'USER');

-- A despejar estrutura para tabela bdmovies.trabalho
DROP TABLE IF EXISTS `trabalho`;
CREATE TABLE IF NOT EXISTS `trabalho` (
  `salario` float NOT NULL,
  `codigoCinema` int(11) NOT NULL,
  `biEmpregado` int(11) NOT NULL,
  KEY `codigoCinema` (`codigoCinema`),
  KEY `biEmpregado` (`biEmpregado`),
  CONSTRAINT `biEmpregado` FOREIGN KEY (`biEmpregado`) REFERENCES `empregado` (`bi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `codigoCinema` FOREIGN KEY (`codigoCinema`) REFERENCES `cinema` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.trabalho: ~0 rows (aproximadamente)
DELETE FROM `trabalho`;

-- A despejar estrutura para tabela bdmovies.utilizador
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE IF NOT EXISTS `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `pw` varchar(100) DEFAULT NULL,
  `idtuser` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_utilizador_tipouser` (`idtuser`) USING BTREE,
  CONSTRAINT `FK_utilizador_tipouser` FOREIGN KEY (`idtuser`) REFERENCES `tipouser` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.utilizador: ~1 rows (aproximadamente)
DELETE FROM `utilizador`;
INSERT INTO `utilizador` (`id`, `user`, `pw`, `idtuser`, `foto`) VALUES
	(8, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 'src/img/user/user.webp'),
	(9, 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', 2, 'src/img/user/user.webp');

-- A despejar estrutura para tabela bdmovies.votacao
DROP TABLE IF EXISTS `votacao`;
CREATE TABLE IF NOT EXISTS `votacao` (
  `numCliente` int(11) NOT NULL,
  `idImdbFilme` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  KEY `numCliente` (`numCliente`),
  CONSTRAINT `numCliente` FOREIGN KEY (`numCliente`) REFERENCES `cliente` (`numCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela bdmovies.votacao: ~0 rows (aproximadamente)
DELETE FROM `votacao`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
