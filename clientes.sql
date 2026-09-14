-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/09/2026 às 21:23
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
-- Banco de dados: `clientes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes1`
--

CREATE TABLE `clientes1` (
  `Código do Cliente` int(11) NOT NULL,
  `Nome Completo` text NOT NULL,
  `CPF` varchar(17) NOT NULL,
  `E-mail` varchar(250) NOT NULL,
  `Telefone` text NOT NULL,
  `Endereço` varchar(250) NOT NULL,
  `Cidade` text NOT NULL,
  `Estado` text NOT NULL,
  `Data Cadastro` date NOT NULL,
  `Data de Nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes2`
--

CREATE TABLE `clientes2` (
  `Código do Cliente` int(11) NOT NULL,
  `Nome Completo` varchar(250) NOT NULL,
  `CPF` int(17) NOT NULL,
  `E-mail` int(250) NOT NULL,
  `Telefone` int(20) NOT NULL,
  `Endereço` int(250) NOT NULL,
  `Cidade` int(250) NOT NULL,
  `Estado` int(250) NOT NULL,
  `Data Cadastro` date NOT NULL,
  `Data de Nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `codigo_estoque` int(11) NOT NULL,
  `codigo_produto` int(250) NOT NULL,
  `quantidade` text NOT NULL,
  `localizacao` text NOT NULL,
  `ultima_atualização` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `Codigo do produto` int(11) NOT NULL,
  `Nome Produto` varchar(250) NOT NULL,
  `Descrição` text NOT NULL,
  `Preço Unitário` varchar(250) NOT NULL,
  `Categoria` text NOT NULL,
  `Marca` text NOT NULL,
  `Data de Fabricação` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `codigo_venda` int(250) NOT NULL,
  `codigo_cliente` int(250) NOT NULL,
  `codigo_produto` int(250) NOT NULL,
  `data_venda` date NOT NULL,
  `valor_total` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes1`
--
ALTER TABLE `clientes1`
  ADD PRIMARY KEY (`Código do Cliente`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices de tabela `clientes2`
--
ALTER TABLE `clientes2`
  ADD PRIMARY KEY (`Código do Cliente`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`codigo_estoque`),
  ADD UNIQUE KEY `codigo_produto` (`codigo_produto`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`Codigo do produto`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`codigo_venda`),
  ADD UNIQUE KEY `codigo_cliente` (`codigo_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
