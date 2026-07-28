CREATE DATABASE IF NOT EXISTS `projeto_repo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `tipo` enum('comum','admin','master') NOT NULL DEFAULT 'comum',
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `unique_id` varchar(36) NOT NULL DEFAULT uuid(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `unique_id` (`unique_id`)
)

CREATE TABLE `recovery_keys` (
  `id_key` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `key_recover` varchar(6) NOT NULL,
  `create_at` datetime NOT NULL
)

CREATE TABLE `logs_acesso` (
  `id_log` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  foreign key (`user_id`) references `usuarios`(`id_user`),
  `acao` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `data_hora` timestamp NOT NULL DEFAULT current_timestamp()
) 

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `numero_cliente` varchar(30) NOT NULL UNIQUE,
  `nome_cliente` varchar(60) NOT NULL,
  `contato_cliente` int(11) DEFAULT NULL,
  `cnpj_cliente` int(11) DEFAULT NULL,
  `gm_cliente` ENUM('sim', 'nâo') DEFAULT 'nâo',
  `status_cliente` ENUM('ativo', 'inativo') DEFAULT 'ativo',
  `unique_id` varchar(36) DEFAULT uuid(),
  `CREATE_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `UPDATE_AT` datetime NOT NULL
)

CREATE TABLE pedidos (
	id_pedido int primary key not null AUTO_INCREMENT,
  num_pedido int unique not null,
  `unique_id` varchar(36) DEFAULT uuid(),
  create_at datetime not null DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE conferente (
	id_conferente int PRIMARY key not null AUTO_INCREMENT,
    nome_conferente varchar(30) not null,
    turno_conferente ENUM('DIA', 'NOITE') DEFAULT 'DIA',
    tipo_conferente ENUM('marcador', 'conferente') DEFAULT 'marcador',
    status_conferente ENUM('ativo', 'inativo') DEFAULT 'ativo',
    `unique_id` varchar(36) DEFAULT uuid(),
    CREATE_AT datetime not null DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tipo_vidro (
	id_vidro int PRIMARY key not null AUTO_INCREMENT,
    tipo_vidro varchar(30) not null,
    `unique_id` varchar(36) DEFAULT uuid(),
    CREATE_AT datetime not null DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE espessura (
	id_espessura int PRIMARY key not null AUTO_INCREMENT,
    tam_espessura varchar(6) not null,
    `unique_id` varchar(36) DEFAULT uuid(),
    CREATE_AT datetime not null DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `motivo` (
  `id_motivo` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `motivo` varchar(60) NOT NULL,
  `unique_id` varchar(36) DEFAULT uuid(),
  `CREATE_AT` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) 

CREATE TABLE peca (
	id_peca int PRIMARY key not null AUTO_INCREMENT,
    num_peca varchar(15) not null,
    pedido_id int not null,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id_pedido),
    data_protocolo datetime not null DEFAULT CURRENT_TIMESTAMP,
    motivo_id int not null,
    FOREIGN KEY (motivo_id) REFERENCES motivo(id_motivo),
    conferente_id int not null,
    FOREIGN KEY (conferente_id) REFERENCES conferente(id_conferente),
    data_erro varchar(26) DEFAULT null,
    turno_peca ENUM('DIA', 'NOITE') DEFAULT null,
    vidro_id int not null,
    FOREIGN KEY (vidro_id) REFERENCES tipo_vidro(id_vidro),
    espessura_id int not null,
    FOREIGN KEY (espessura_id) REFERENCES espessura(id_espessura),
    setor_peca ENUM('PRODUÇÃO', 'EXPEDIÇÃO') DEFAULT null,
    obs_peca varchar(260) DEFAULT null,
    altura_peca int not null,
    largura_peca int not null,
    m2_peca DECIMAL(10,4) AS ((altura_peca * largura_peca) / 10000) STORED,
    `unique_id` varchar(36) DEFAULT uuid(),
    CREATE_AT datetime not null,
    UPDATE_AT datetime not null DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE devolucao (
	id_devolucao int PRIMARY KEY not null AUTO_INCREMENT,
    peca_id int not null,
    FOREIGN KEY (peca_id) REFERENCES peca(id_peca),
    data_devolucao datetime DEFAULT null,
    obs_devolucao varchar(260) DEFAULT null
);