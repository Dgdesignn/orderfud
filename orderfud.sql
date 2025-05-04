-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:5406
-- Tempo de geração: 04-Maio-2025 às 15:47
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `orderfud`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

CREATE TABLE `adm` (
  `idAdm` int(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `dataDaCriacao` date DEFAULT NULL,
  `imagem` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `adm`
--

INSERT INTO `adm` (`idAdm`, `nome`, `telefone`, `senha`, `dataDaCriacao`, `imagem`) VALUES
(1, 'Helder', '923456789', '123456', '0000-00-00', ''),
(2, 'Pai Profeta', '923456789', '123456', '0000-00-00', ''),
(3, 'Pai Profeta', '923456789', '123456', '0000-00-00', ''),
(4, 'Pai Profeta', '923456789', '123456', '0000-00-00', ''),
(6, 'noite e dia', '923456789', '123456', '0000-00-00', ''),
(7, 'titica', '923456789', '123456', '0000-00-00', ''),
(8, 'ary', '923456789', '123456', '2025-02-28', ''),
(9, 'Simão ', '987654321', '123456', '2025-03-01', ''),
(10, 'Simão ', '987654321', '123456', '2025-03-01', ''),
(11, 'user1', '999888777', '$2y$10$/tgAb83paQgbOyNfOrf7XuBl.lmuPeeY5WsHcrDZi2FAZLFK1QS6a', '2025-03-01', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `img` varchar(250) NOT NULL,
  `imagem` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `categoria`, `img`, `imagem`) VALUES
(23, 'Fastfood', '', 'uploads/Categorias/679b36ff66065-burger.png'),
(24, 'Bebidas', '', 'uploads/Categorias/679b377eaef2f-soft-drink.png'),
(25, 'Aperitivos', '', 'uploads/Categorias/679b37fe22aed-potato-chips.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `tipoCliente` varchar(15) NOT NULL,
  `imagem` varchar(250) DEFAULT NULL,
  `bloqueado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nome`, `telefone`, `senha`, `tipoCliente`, `imagem`, `bloqueado`) VALUES
(29, 'Ricardina1', '940341098', '$2y$10$ctxg3klbp18X8', 'aluno', '', 0),
(36, 'Daniel Web', '931974210', '$2y$10$dYKw47yjJ5uUDLTrmydPrec6Nm0cISo581/CUig.nFnQIXsYfTfz.', '', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_carteira`
--

CREATE TABLE `cliente_carteira` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `telefone` text DEFAULT NULL,
  `senha` varchar(10) DEFAULT NULL,
  `tipoCliente` text DEFAULT NULL,
  `fk_Turma_idTurma` int(11) DEFAULT NULL,
  `idCarteira` int(11) NOT NULL,
  `saldo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `senha` varchar(250) DEFAULT NULL,
  `imagem` varchar(250) NOT NULL,
  `tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `nome`, `telefone`, `senha`, `imagem`, `tipo`) VALUES
(100, 'lino', '	999999222', '$2y$10$MJvAr.fNnCh5az8nc0kfreDBPmybIcgIvEbrebraAglEzd1gx9dR6', '', 'Funcionária'),
(101, 'Domingos Richarlison', '999999111', '$2y$10$3qfnJtQG9cCfj0p5QG31lOHA4IsVeIRmVjY4dTRPn2usoMqmLi2wa', '', 'Funcionária'),
(103, 'fantass', '989899898', '$2y$10$jwxg.iQQ3M2JJPKHnedhZuhsRoHiHrtzfaWbpbFEFsV2LeU6ORLuq', 'uploads/funcionaros/6808af16460e5-user2.jpg', 'administrador'),
(104, 'delcio', '999999221', '$2y$10$WzfEbkeGCstB98FUSrggye5yWClX1x0s85Sqyzwwhx8Rb0A0rVAhi', 'uploads/funcionaros/6809e807ccbbf-user2.jpg', 'Funcionária');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `lida` tinyint(1) DEFAULT 0,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `fk_Cliente_idCliente` int(11) NOT NULL,
  `data_pedido` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','em_preparo','pronto','entregue','cancelado') NOT NULL DEFAULT 'pendente',
  `total` decimal(10,2) NOT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`idPedido`, `fk_Cliente_idCliente`, `data_pedido`, `status`, `total`, `observacoes`) VALUES
(39, 36, '2025-05-01 17:19:40', 'pendente', 8700.00, 'tr56r56r56r');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_produto`
--

CREATE TABLE `pedido_produto` (
  `idPedido_produto` int(11) NOT NULL,
  `fk_Pedido_idPedido` int(11) NOT NULL,
  `fk_Produto_idProduto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`quantidade` * `preco_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedido_produto`
--

INSERT INTO `pedido_produto` (`idPedido_produto`, `fk_Pedido_idPedido`, `fk_Produto_idProduto`, `quantidade`, `preco_unitario`) VALUES
(26, 39, 39, 1, 8000.00),
(27, 39, 22, 1, 700.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `idFuncionario` int(11) DEFAULT NULL,
  `imagem` varchar(250) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `nome`, `descricao`, `preco`, `idCategoria`, `idFuncionario`, `imagem`, `estado`) VALUES
(20, 'Coca-Cola', 'A Coca-Cola Original é o refrigerante mais tradicional e consumido no mundo. ', 500, 24, NULL, 'uploads/Produtos/679b391eeb5db-cocaloca.jpg', 0),
(22, 'Batata LuLu', ' Prato típico da Angola, feito com pão, frango frito desfiado, salada de repolho, pimenta malagueta, podendo colocar maionese e ketchup.\r\n', 700, 25, NULL, 'uploads/Produtos/679b982f529d7-batataLulu.jpg', 0),
(39, 'fanta', 'nmnnn', 8000, 23, NULL, 'uploads/Produtos/6808accfe3423-user2.jpg', 0),
(51, 'Hamburguer', 'stegshja asdew', 5700, 23, NULL, 'uploads/produto/681400a09f238.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recebe`
--

CREATE TABLE `recebe` (
  `fk_Funcionario_idFuncionario` int(11) DEFAULT NULL,
  `fk_Pedido_idPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tem`
--

CREATE TABLE `tem` (
  `fk_Pedido_idPedido` int(11) DEFAULT NULL,
  `fk_Produto_idProduto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `idTurma` int(11) NOT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `classe` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`idTurma`, `sigla`, `classe`) VALUES
(1, 'TGS', '12º'),
(2, 'if', '10'),
(22, 'if', '10'),
(23, '12°', '10'),
(24, '12°', '10'),
(25, '12°', '10'),
(26, '12°', '10');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`idAdm`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices para tabela `cliente_carteira`
--
ALTER TABLE `cliente_carteira`
  ADD PRIMARY KEY (`id`,`idCarteira`),
  ADD KEY `FK_Cliente_Carteira_2` (`fk_Turma_idTurma`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idFuncionario`);

--
-- Índices para tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario_id` (`funcionario_id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_Cliente_idCliente` (`fk_Cliente_idCliente`);

--
-- Índices para tabela `pedido_produto`
--
ALTER TABLE `pedido_produto`
  ADD PRIMARY KEY (`idPedido_produto`),
  ADD KEY `fk_Pedido_idPedido` (`fk_Pedido_idPedido`),
  ADD KEY `fk_Produto_idProduto` (`fk_Produto_idProduto`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `FK_Produto_2` (`idCategoria`),
  ADD KEY `FK_Produto_3` (`idFuncionario`);

--
-- Índices para tabela `recebe`
--
ALTER TABLE `recebe`
  ADD KEY `FK_recebe_1` (`fk_Funcionario_idFuncionario`),
  ADD KEY `FK_recebe_2` (`fk_Pedido_idPedido`);

--
-- Índices para tabela `tem`
--
ALTER TABLE `tem`
  ADD KEY `FK_tem_1` (`fk_Pedido_idPedido`),
  ADD KEY `FK_tem_2` (`fk_Produto_idProduto`);

--
-- Índices para tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`idTurma`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `idAdm` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `cliente_carteira`
--
ALTER TABLE `cliente_carteira`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `pedido_produto`
--
ALTER TABLE `pedido_produto`
  MODIFY `idPedido_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `idTurma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cliente_carteira`
--
ALTER TABLE `cliente_carteira`
  ADD CONSTRAINT `FK_Cliente_Carteira_2` FOREIGN KEY (`fk_Turma_idTurma`) REFERENCES `turma` (`idTurma`);

--
-- Limitadores para a tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`idFuncionario`),
  ADD CONSTRAINT `notificacoes_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`idPedido`);

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`fk_Cliente_idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Limitadores para a tabela `pedido_produto`
--
ALTER TABLE `pedido_produto`
  ADD CONSTRAINT `pedido_produto_ibfk_1` FOREIGN KEY (`fk_Pedido_idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_produto_ibfk_2` FOREIGN KEY (`fk_Produto_idProduto`) REFERENCES `produto` (`idProduto`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `FK_Produto_2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `FK_Produto_3` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `recebe`
--
ALTER TABLE `recebe`
  ADD CONSTRAINT `FK_recebe_1` FOREIGN KEY (`fk_Funcionario_idFuncionario`) REFERENCES `funcionario` (`idFuncionario`),
  ADD CONSTRAINT `FK_recebe_2` FOREIGN KEY (`fk_Pedido_idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `tem`
--
ALTER TABLE `tem`
  ADD CONSTRAINT `FK_tem_1` FOREIGN KEY (`fk_Pedido_idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `FK_tem_2` FOREIGN KEY (`fk_Produto_idProduto`) REFERENCES `produto` (`idProduto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
