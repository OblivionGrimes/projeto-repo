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
