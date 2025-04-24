/* Lógico_1: */

CREATE TABLE Cliente_Carteira (
    id int AUTO_INCREMENT,
    nome varchar(50),
    telefone text,
    senha varchar(10),
    tipoCliente text,
    fk_Turma_idTurma int,
    idCarteira int,
    saldo text,
    PRIMARY KEY (id, idCarteira)
);



CREATE TABLE Pedido (
    idPedido int PRIMARY KEY AUTO_INCREMENT,
    data date,
    quantidade int,
    fk_Cliente_Carteira_id int,
    fk_Cliente_Carteira_idCarteira int
);

CREATE TABLE Produto (
    idProduto int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(50),
    descricao text,
    preco int,
    quantidade int,
    fk_Categoria_idCategoria int,
    fk_Funcionario_idFuncionario int
);

CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    produto_id INT NOT NULL,
    UNIQUE (user_id, produto_id)
);



CREATE TABLE Funcionario (
    idFuncionario int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(50),
    telefone varchar(15),
    senha varchar(10)
);

CREATE TABLE Categoria (
    idCategoria int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(50)
);

CREATE Table carrinho(
    id INT AUTO_INCREMENT
);

CREATE TABLE tem (
    fk_Pedido_idPedido int,
    fk_Produto_idProduto int
);

CREATE TABLE recebe (
    fk_Funcionario_idFuncionario int,
    fk_Pedido_idPedido int
);
 
ALTER TABLE Cliente_Carteira ADD CONSTRAINT FK_Cliente_Carteira_2
    FOREIGN KEY (fk_Turma_idTurma)
    REFERENCES Turma (idTurma)
    ON DELETE RESTRICT;
 
ALTER TABLE Pedido ADD CONSTRAINT FK_Pedido_2
    FOREIGN KEY (fk_Cliente_Carteira_id, fk_Cliente_Carteira_idCarteira)
    REFERENCES Cliente_Carteira (id, idCarteira)
    ON DELETE CASCADE;
 
ALTER TABLE Produto ADD CONSTRAINT FK_Produto_2
    FOREIGN KEY (fk_Categoria_idCategoria)
    REFERENCES Categoria (idCategoria)
    ON DELETE RESTRICT;
 
ALTER TABLE Produto ADD CONSTRAINT FK_Produto_3
    FOREIGN KEY (fk_Funcionario_idFuncionario)
    REFERENCES Funcionario (idFuncionario)
    ON DELETE CASCADE;
 
ALTER TABLE tem ADD CONSTRAINT FK_tem_1
    FOREIGN KEY (fk_Pedido_idPedido)
    REFERENCES Pedido (idPedido)
    ON DELETE RESTRICT;
 
ALTER TABLE tem ADD CONSTRAINT FK_tem_2
    FOREIGN KEY (fk_Produto_idProduto)
    REFERENCES Produto (idProduto)
    ON DELETE RESTRICT;
 
ALTER TABLE recebe ADD CONSTRAINT FK_recebe_1
    FOREIGN KEY (fk_Funcionario_idFuncionario)
    REFERENCES Funcionario (idFuncionario)
    ON DELETE RESTRICT;
 
ALTER TABLE recebe ADD CONSTRAINT FK_recebe_2
    FOREIGN KEY (fk_Pedido_idPedido)
    REFERENCES Pedido (idPedido)
    ON DELETE SET NULL;