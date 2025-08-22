-- Criação do banco de dados
CREATE DATABASE tcc;
USE tcc;

-- Tabela de usuários
CREATE TABLE usuario (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    tipo_usuario char(1),
    senha VARCHAR(50) NOT NULL
);
-- Tabela de matérias
CREATE TABLE IF NOT EXISTS materia (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);


-- Tabela de vestibulares
CREATE TABLE vestibular (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL
);

-- Tabela de questões
CREATE TABLE questao (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_materia INT,
    id_faculdade INT,
    id_vestibular INT,
    enunciado VARCHAR(500) NOT NULL,
    dificuldade VARCHAR(20),
    alt_correta VARCHAR(200),
    a VARCHAR(200),
    b VARCHAR(200),
    c VARCHAR(200),
    d VARCHAR(200),
    e VARCHAR(200),
    CONSTRAINT fk_id_materia FOREIGN KEY (id_materia) REFERENCES materia(id),
    CONSTRAINT fk_id_vestibular FOREIGN KEY (id_vestibular) REFERENCES vestibular(id)
);

insert into vestibular(nome)
values
('Fuvest'),
('Vunesp'),
('Enem');




