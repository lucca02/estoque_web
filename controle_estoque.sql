-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/11/2026 às 23:13
-- Versão do servidor: 10.11.16-MariaDB
-- Versão do PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `controle_estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`) VALUES
(44, 'Absorventes'),
(22, 'Águas'),
(33, 'Alimentos Preparados'),
(13, 'Azeites e Óleos'),
(46, 'Barbear'),
(10, 'Bebidas em Pó'),
(23, 'Bebidas Esportivas'),
(15, 'Biscoitos'),
(20, 'Café'),
(3, 'Carnes'),
(16, 'Cereais'),
(24, 'Cervejas'),
(18, 'Chocolates'),
(8, 'Congelados'),
(14, 'Conservas'),
(48, 'Descartáveis'),
(35, 'Desinfetantes'),
(42, 'Desodorantes'),
(26, 'Destilados'),
(36, 'Detergentes'),
(19, 'Doces e Balas'),
(37, 'Esponjas'),
(32, 'Farinhas'),
(27, 'Fórmulas Infantis'),
(45, 'Fraldas'),
(5, 'Frios e Embutidos'),
(1, 'Frutas'),
(11, 'Grãos'),
(41, 'Higiene Bucal'),
(38, 'Inseticidas'),
(6, 'Laticínios'),
(12, 'Massas'),
(29, 'Mel e Geleias'),
(2, 'Panificação'),
(49, 'Papelaria'),
(4, 'Peixes'),
(47, 'Produtos para Animais'),
(28, 'Produtos Sem Glúten'),
(43, 'Protetores Solares'),
(7, 'Queijos'),
(21, 'Refrigerantes'),
(30, 'Refrigerantes Zero'),
(34, 'Sabão em Pó'),
(40, 'Sabonetes'),
(17, 'Salgadinhos'),
(39, 'Shampoo'),
(9, 'Sorvetes'),
(31, 'Temperos'),
(50, 'Utilidades Domésticas'),
(25, 'Vinhos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `id_movimentacao` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` enum('entrada','saida') NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `data_movimentacao` datetime NOT NULL DEFAULT current_timestamp(),
  `observacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacoes`
--

INSERT INTO `movimentacoes` (`id_movimentacao`, `id_produto`, `id_usuario`, `tipo`, `quantidade`, `preco_unitario`, `data_movimentacao`, `observacao`) VALUES
(1, 1, 3, 'entrada', 10, 5.99, '2026-01-05 00:00:00', 'Compra programada mensal'),
(2, 2, 5, 'saida', 4, 8.49, '2026-01-10 00:00:00', 'Venda registrada no caixa'),
(3, 3, 4, 'entrada', 8, 17.90, '2026-01-15 00:00:00', 'Reposição de estoque via fornecedor'),
(4, 4, 6, 'saida', 3, 24.90, '2026-01-20 00:00:00', 'Saída para pedido on-line'),
(5, 5, 7, 'entrada', 10, 8.99, '2026-01-25 00:00:00', 'Recebimento de mercadoria'),
(6, 6, 8, 'saida', 7, 5.49, '2026-01-30 00:00:00', 'Venda ao cliente no balcão'),
(7, 7, 10, 'entrada', 6, 22.90, '2026-02-04 00:00:00', 'Compra programada mensal'),
(8, 8, 11, 'saida', 4, 13.99, '2026-02-09 00:00:00', 'Venda registrada no caixa'),
(9, 9, 12, 'entrada', 6, 19.90, '2026-02-14 00:00:00', 'Reposição de estoque via fornecedor'),
(10, 10, 13, 'saida', 5, 8.99, '2026-02-19 00:00:00', 'Saída para pedido on-line'),
(11, 11, 14, 'entrada', 20, 6.99, '2026-02-24 00:00:00', 'Recebimento de mercadoria'),
(12, 12, 15, 'saida', 8, 4.79, '2026-03-01 00:00:00', 'Venda ao cliente no balcão'),
(13, 13, 16, 'entrada', 9, 29.90, '2026-03-06 00:00:00', 'Compra programada mensal'),
(14, 14, 17, 'saida', 6, 3.49, '2026-03-11 00:00:00', 'Venda registrada no caixa'),
(15, 15, 18, 'entrada', 14, 5.49, '2026-03-16 00:00:00', 'Reposição de estoque via fornecedor'),
(16, 16, 19, 'saida', 4, 11.90, '2026-03-21 00:00:00', 'Saída para pedido on-line'),
(17, 17, 20, 'entrada', 15, 7.49, '2026-03-26 00:00:00', 'Recebimento de mercadoria'),
(18, 18, 21, 'saida', 10, 6.49, '2026-03-31 00:00:00', 'Venda ao cliente no balcão'),
(19, 19, 22, 'entrada', 18, 3.99, '2026-04-05 00:00:00', 'Compra programada mensal'),
(20, 20, 23, 'saida', 7, 16.90, '2026-04-10 00:00:00', 'Venda registrada no caixa'),
(21, 21, 24, 'entrada', 20, 9.49, '2026-04-15 00:00:00', 'Reposição de estoque via fornecedor'),
(22, 22, 25, 'saida', 12, 3.49, '2026-04-20 00:00:00', 'Saída para pedido on-line'),
(23, 23, 26, 'entrada', 16, 5.99, '2026-04-25 00:00:00', 'Recebimento de mercadoria'),
(24, 24, 27, 'saida', 14, 4.49, '2026-04-30 00:00:00', 'Venda ao cliente no balcão'),
(25, 25, 28, 'entrada', 8, 29.90, '2026-05-05 00:00:00', 'Compra programada mensal'),
(26, 26, 29, 'saida', 3, 39.90, '2026-05-10 00:00:00', 'Venda registrada no caixa'),
(27, 27, 32, 'entrada', 5, 49.90, '2026-05-15 00:00:00', 'Reposição de estoque via fornecedor'),
(28, 28, 31, 'saida', 3, 9.90, '2026-05-20 00:00:00', 'Saída para pedido on-line'),
(29, 29, 34, 'entrada', 5, 22.90, '2026-05-25 00:00:00', 'Recebimento de mercadoria'),
(30, 30, 33, 'saida', 6, 9.49, '2026-05-30 00:00:00', 'Venda ao cliente no balcão'),
(31, 31, 36, 'entrada', 11, 3.99, '2026-06-04 00:00:00', 'Compra programada mensal'),
(32, 32, 35, 'saida', 7, 5.99, '2026-06-09 00:00:00', 'Venda registrada no caixa'),
(33, 33, 38, 'entrada', 5, 29.90, '2026-06-14 00:00:00', 'Reposição de estoque via fornecedor'),
(34, 34, 37, 'saida', 5, 12.99, '2026-06-19 00:00:00', 'Saída para pedido on-line'),
(35, 35, 40, 'entrada', 15, 5.49, '2026-06-24 00:00:00', 'Recebimento de mercadoria'),
(36, 36, 39, 'saida', 11, 2.49, '2026-06-29 00:00:00', 'Venda ao cliente no balcão'),
(37, 37, 42, 'entrada', 25, 2.99, '2026-07-04 00:00:00', 'Compra programada mensal'),
(38, 38, 41, 'saida', 4, 14.90, '2026-07-09 00:00:00', 'Venda registrada no caixa'),
(39, 39, 44, 'entrada', 9, 14.90, '2026-07-14 00:00:00', 'Reposição de estoque via fornecedor'),
(40, 40, 43, 'saida', 10, 3.49, '2026-07-19 00:00:00', 'Saída para pedido on-line'),
(41, 41, 46, 'entrada', 12, 6.99, '2026-07-24 00:00:00', 'Recebimento de mercadoria'),
(42, 42, 45, 'saida', 5, 11.90, '2026-07-29 00:00:00', 'Venda ao cliente no balcão'),
(43, 43, 48, 'entrada', 6, 39.90, '2026-08-03 00:00:00', 'Compra programada mensal'),
(44, 44, 47, 'saida', 7, 8.99, '2026-08-08 00:00:00', 'Venda registrada no caixa'),
(45, 45, 3, 'entrada', 9, 39.90, '2026-08-13 00:00:00', 'Reposição de estoque via fornecedor'),
(46, 46, 49, 'saida', 4, 12.90, '2026-08-18 00:00:00', 'Saída para pedido on-line'),
(47, 47, 4, 'entrada', 10, 13.90, '2026-08-23 00:00:00', 'Recebimento de mercadoria'),
(48, 48, 5, 'saida', 6, 7.99, '2026-08-28 00:00:00', 'Venda ao cliente no balcão'),
(49, 49, 7, 'entrada', 8, 19.90, '2026-09-02 00:00:00', 'Compra programada mensal'),
(50, 50, 6, 'saida', 3, 15.90, '2026-09-07 00:00:00', 'Venda registrada no caixa'),
(51, 26, 1, 'entrada', 5, 39.87, '2026-11-04 02:36:23', 'Ajuste de estoque'),
(52, 26, 1, 'saida', 5, 39.90, '2026-11-04 22:48:22', 'Ajuste de estoque');

--
-- Acionadores `movimentacoes`
--
DELIMITER $$
CREATE TRIGGER `trg_atualiza_estoque` AFTER INSERT ON `movimentacoes` FOR EACH ROW BEGIN
    IF NEW.tipo = 'ENTRADA' THEN
        UPDATE produtos SET quantidade_estoque = quantidade_estoque + NEW.quantidade WHERE id_produto = NEW.id_produto;
    ELSEIF NEW.tipo = 'SAIDA' THEN
        UPDATE produtos SET quantidade_estoque = quantidade_estoque - NEW.quantidade WHERE id_produto = NEW.id_produto;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_valida_movimentacao` BEFORE INSERT ON `movimentacoes` FOR EACH ROW BEGIN
    IF NEW.quantidade <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A quantidade da movimentacao deve ser maior que zero';
    END IF;

    IF NEW.tipo = 'SAIDA' THEN
        IF NEW.quantidade > (SELECT quantidade_estoque FROM produtos WHERE id_produto = NEW.id_produto) THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Estoque insuficiente para realizar a saída';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `quantidade_estoque` int(11) NOT NULL DEFAULT 0,
  `preco_venda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `codigo`, `nome`, `id_categoria`, `quantidade_estoque`, `preco_venda`) VALUES
(1, 'ALI001', 'Banana Prata 1kg', 1, 50, 5.99),
(2, 'ALI002', 'Pão de Forma 500g', 2, 31, 8.49),
(3, 'ALI003', 'Peito de Frango 1kg', 3, 38, 17.90),
(4, 'ALI004', 'Filé de Tilápia 500g', 4, 17, 24.90),
(5, 'ALI005', 'Presunto Fatiado 200g', 5, 50, 8.99),
(6, 'ALI006', 'Leite Integral 1L', 6, 53, 5.49),
(7, 'ALI007', 'Queijo Brie 125g', 7, 31, 22.90),
(8, 'ALI008', 'Lasanha Congelada 600g', 8, 26, 13.99),
(9, 'ALI009', 'Sorvete de Chocolate 1,5L', 9, 31, 19.90),
(10, 'ALI010', 'Achocolatado em Pó 400g', 10, 40, 8.99),
(11, 'ALI011', 'Arroz Branco 1kg', 11, 100, 6.99),
(12, 'ALI012', 'Macarrão Espaguete 500g', 12, 62, 4.79),
(13, 'ALI013', 'Azeite de Oliva 500ml', 13, 44, 29.90),
(14, 'ALI014', 'Milho Verde em Lata 170g', 14, 44, 3.49),
(15, 'ALI015', 'Biscoito Cream Cracker 350g', 15, 69, 5.49),
(16, 'ALI016', 'Granola Tradicional 250g', 16, 26, 11.90),
(17, 'ALI017', 'Batata Chips 100g', 17, 75, 7.49),
(18, 'ALI018', 'Chocolate ao Leite 90g', 18, 70, 6.49),
(19, 'ALI019', 'Bala de Morango 100g', 19, 88, 3.99),
(20, 'ALI020', 'Café Torrado e Moído 500g', 20, 48, 16.90),
(21, 'BEB001', 'Refrigerante Cola 2L', 21, 100, 9.49),
(22, 'BEB002', 'Água Mineral 1,5L', 22, 88, 3.49),
(23, 'BEB003', 'Bebida Isotônica 500ml', 23, 81, 5.99),
(24, 'BEB004', 'Cerveja Pilsen 350ml', 24, 106, 4.49),
(25, 'BEB005', 'Vinho Tinto Suave 750ml', 25, 38, 29.90),
(26, 'BEB006', 'Vodka 1L', 26, 12, 39.90),
(27, 'ALI021', 'Leite em Fórmula Infantil 800g', 27, 25, 49.90),
(28, 'ALI022', 'Biscoito Sem Glúten 120g', 28, 22, 9.90),
(29, 'ALI023', 'Mel Orgânico 300g', 29, 25, 22.90),
(30, 'ALI024', 'Refrigerante Zero 2L', 30, 44, 9.49),
(31, 'ALI025', 'Orégano 20g', 31, 56, 3.99),
(32, 'ALI026', 'Farinha de Trigo 1kg', 32, 48, 5.99),
(33, 'ALI027', 'Frango Assado Inteiro', 33, 20, 29.90),
(34, 'LIM001', 'Sabão em Pó 1kg', 34, 40, 12.99),
(35, 'LIM002', 'Desinfetante 500ml', 35, 75, 5.49),
(36, 'LIM003', 'Detergente 500ml', 36, 79, 2.49),
(37, 'LIM004', 'Esponja de Louça', 37, 125, 2.99),
(38, 'LIM005', 'Inseticida Aerosol 300ml', 38, 26, 14.90),
(39, 'HIG001', 'Shampoo 350ml', 39, 44, 14.90),
(40, 'HIG002', 'Sabonete em Barra 90g', 40, 70, 3.49),
(41, 'HIG003', 'Creme Dental 90g', 41, 62, 6.99),
(42, 'HIG004', 'Desodorante Aerosol 150ml', 42, 35, 11.90),
(43, 'HIG005', 'Protetor Solar FPS 50', 43, 31, 39.90),
(44, 'HIG006', 'Absorvente com Abas', 44, 53, 8.99),
(45, 'HIG007', 'Fralda Infantil Tamanho M', 45, 44, 39.90),
(46, 'HIG008', 'Aparelho de Barbear Descartável', 46, 26, 12.90),
(47, 'PET001', 'Ração para Cães 1kg', 47, 50, 13.90),
(48, 'UTI001', 'Copos Descartáveis 200ml', 48, 44, 7.99),
(49, 'PAP001', 'Caderno Universitário 10 Matérias', 49, 38, 19.90),
(50, 'BAZ001', 'Vela Aromática', 50, 17, 15.90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `telefone`, `senha`, `cargo`, `ativo`) VALUES
(1, 'Ana Beatriz Souza', 'ana.souza@estoque.com', '11943216789', 'Ana@123', 'Administrador', 1),
(2, 'Carlos Eduardo Lima', 'carlos.lima@estoque.com', NULL, 'Carlos@123', 'Gerente', 1),
(3, 'Mariana Oliveira Santos', 'mariana.santos@estoque.com', NULL, 'Mariana@123', 'Estoquista', 1),
(4, 'João Pedro Almeida', 'joao.almeida@estoque.com', NULL, 'Joao@123', 'Estoquista', 1),
(5, 'Gabriela Martins Costa', 'gabriela.costa@estoque.com', NULL, 'Gabriela@123', 'Vendedor', 1),
(6, 'Lucas Henrique Silva', 'lucas.silva@estoque.com', NULL, 'Lucas@123', 'Vendedor', 1),
(7, 'Beatriz Rodrigues', 'beatriz.rodrigues@estoque.com', NULL, 'Beatriz@123', 'Estoquista', 1),
(8, 'Rafael Mendes', 'rafael.mendes@estoque.com', NULL, 'Rafael@123', 'Vendedor', 1),
(9, 'Juliana Ferreira', 'juliana.ferreira@estoque.com', NULL, 'Juliana@123', 'Gerente', 1),
(10, 'Pedro Henrique Alves', 'pedro.alves@estoque.com', NULL, 'Pedro@123', 'Estoquista', 1),
(11, 'Larissa Gomes', 'larissa.gomes@estoque.com', NULL, 'Larissa@123', 'Vendedor', 1),
(12, 'Matheus Rodrigues', 'matheus.rodrigues@estoque.com', NULL, 'Matheus@123', 'Estoquista', 1),
(13, 'Camila Nunes', 'camila.nunes@estoque.com', NULL, 'Camila@123', 'Vendedor', 1),
(14, 'Felipe Martins', 'felipe.martins@estoque.com', NULL, 'Felipe@123', 'Estoquista', 1),
(15, 'Isabela Carvalho', 'isabela.carvalho@estoque.com', NULL, 'Isabela@123', 'Vendedor', 1),
(16, 'Gabriel Ferreira', 'gabriel.ferreira@estoque.com', NULL, 'Gabriel@123', 'Estoquista', 1),
(17, 'Letícia Barbosa', 'leticia.barbosa@estoque.com', NULL, 'Leticia@123', 'Vendedor', 1),
(18, 'Bruno Oliveira', 'bruno.oliveira@estoque.com', NULL, 'Bruno@123', 'Estoquista', 1),
(19, 'Vitória Martins', 'vitoria.martins@estoque.com', NULL, 'Vitoria@123', 'Vendedor', 1),
(20, 'Daniel Souza', 'daniel.souza@estoque.com', NULL, 'Daniel@123', 'Estoquista', 1),
(21, 'Amanda Ribeiro', 'amanda.ribeiro@estoque.com', NULL, 'Amanda@123', 'Vendedor', 1),
(22, 'Gustavo Henrique Costa', 'gustavo.costa@estoque.com', NULL, 'Gustavo@123', 'Estoquista', 1),
(23, 'Manuela Dias', 'manuela.dias@estoque.com', NULL, 'Manuela@123', 'Vendedor', 1),
(24, 'Thiago Almeida', 'thiago.almeida@estoque.com', NULL, 'Thiago@123', 'Estoquista', 1),
(25, 'Júlia Fernandes', 'julia.fernandes@estoque.com', NULL, 'Julia@123', 'Vendedor', 1),
(26, 'André Luiz Santos', 'andre.santos@estoque.com', NULL, 'Andre@123', 'Estoquista', 1),
(27, 'Sophia Martins', 'sophia.martins@estoque.com', NULL, 'Sophia@123', 'Vendedor', 1),
(28, 'Eduardo Gomes', 'eduardo.gomes@estoque.com', NULL, 'Eduardo@123', 'Estoquista', 1),
(29, 'Helena Castro', 'helena.castro@estoque.com', NULL, 'Helena@123', 'Vendedor', 1),
(30, 'Marcelo Pereira', 'marcelo.pereira@estoque.com', NULL, 'Marcelo@123', 'Gerente', 1),
(31, 'Clara Mendes', 'clara.mendes@estoque.com', NULL, 'Clara@123', 'Vendedor', 1),
(32, 'Rodrigo Carvalho', 'rodrigo.carvalho@estoque.com', NULL, 'Rodrigo@123', 'Estoquista', 1),
(33, 'Laura Oliveira', 'laura.oliveira@estoque.com', NULL, 'Laura@123', 'Vendedor', 1),
(34, 'Felipe Augusto Lima', 'felipe.lima@estoque.com', NULL, 'Felipe@456', 'Estoquista', 1),
(35, 'Bianca Santos', 'bianca.santos@estoque.com', NULL, 'Bianca@123', 'Vendedor', 1),
(36, 'Henrique Martins', 'henrique.martins@estoque.com', NULL, 'Henrique@123', 'Estoquista', 1),
(37, 'Alice Ferreira', 'alice.ferreira@estoque.com', NULL, 'Alice@123', 'Vendedor', 1),
(38, 'Leonardo Alves', 'leonardo.alves@estoque.com', NULL, 'Leonardo@123', 'Estoquista', 1),
(39, 'Valentina Costa', 'valentina.costa@estoque.com', NULL, 'Valentina@123', 'Vendedor', 1),
(40, 'Marcelo Henrique Silva', 'marcelo.silva@estoque.com', NULL, 'Marcelo@456', 'Estoquista', 1),
(41, 'Sarah Rodrigues', 'sarah.rodrigues@estoque.com', NULL, 'Sarah@123', 'Vendedor', 1),
(42, 'Diego Mendes', 'diego.mendes@estoque.com', NULL, 'Diego@123', 'Estoquista', 1),
(43, 'Elisa Barbosa', 'elisa.barbosa@estoque.com', NULL, 'Elisa@123', 'Vendedor', 1),
(44, 'Caio Fernandes', 'caio.fernandes@estoque.com', NULL, 'Caio@123', 'Estoquista', 1),
(45, 'Yasmin Oliveira', 'yasmin.oliveira@estoque.com', NULL, 'Yasmin@123', 'Vendedor', 1),
(46, 'Renato Ribeiro', 'renato.ribeiro@estoque.com', NULL, 'Renato@123', 'Estoquista', 1),
(47, 'Luana Martins', 'luana.martins@estoque.com', NULL, 'Luana@123', 'Vendedor', 1),
(48, 'Vinícius Santos', 'vinicius.santos@estoque.com', NULL, 'Vinicius@123', 'Estoquista', 1),
(49, 'Nicole Almeida', 'nicole.almeida@estoque.com', NULL, 'Nicole@123', 'Vendedor', 1),
(50, 'Fernando Costa', 'fernando.costa@estoque.com', NULL, 'Fernando@123', 'Administrador', 1),
(51, 'Lucca Moura Miranda', 'lucca.miranda@estoque.com', '11998405856', 'lucca021209', 'Vendedor', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `fk_movimentacao_produto` (`id_produto`),
  ADD KEY `fk_movimentacao_usuario` (`id_usuario`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `fk_produto_categoria` (`id_categoria`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD CONSTRAINT `fk_movimentacao_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`),
  ADD CONSTRAINT `fk_movimentacao_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
