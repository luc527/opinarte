-- MySQL Workbench Forward Engineering
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema websiteartes
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `websiteartes` DEFAULT CHARACTER SET latin1 ;
USE `websiteartes` ;


-- -----------------------------------------------------
-- Table `websiteartes`.`linguagensart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`linguagensart` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `descricao` VARCHAR(512) NOT NULL COMMENT 'breve definição e descrição sobre a história e características da linguagem\n',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`genero` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL COMMENT 'definição do gênero e descrição de sua história e suas características',
  `lingArte` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `lingArte` (`lingArte` ASC),
  CONSTRAINT `genero_ibfk_1`
    FOREIGN KEY (`lingArte`)
    REFERENCES `websiteartes`.`linguagensart` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`artista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`artista` (
  `id_artista` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `descricao` TEXT NULL,
  `imagemUrl` VARCHAR(256) NULL DEFAULT NULL,
  `website` VARCHAR(150) NULL DEFAULT NULL,
  `facebook` VARCHAR(100) NULL DEFAULT NULL,
  `twitter` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_artista`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`artista_has_genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`artista_has_genero` (
  `artista_id` INT(11) NOT NULL,
  `genero_id` INT(11) NOT NULL,
  PRIMARY KEY (`artista_id`, `genero_id`),
  INDEX `fk_artista_has_genero_genero1_idx` (`genero_id` ASC),
  INDEX `fk_artista_has_genero_artista1_idx` (`artista_id` ASC),
  CONSTRAINT `fk_artista_has_genero_artista1`
    FOREIGN KEY (`artista_id`)
    REFERENCES `websiteartes`.`artista` (`id_artista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_artista_has_genero_genero1`
    FOREIGN KEY (`genero_id`)
    REFERENCES `websiteartes`.`genero` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`obra`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `websiteartes`.`obra` (
  `id_obra` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(256) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `dtLancamento` DATE NULL DEFAULT NULL,
  `imagemUrl` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`id_obra`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`artista_has_obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`artista_has_obra` (
  `artista_id` INT(11) NOT NULL,
  `obra_id` INT(11) NOT NULL,
  PRIMARY KEY (`artista_id`, `obra_id`),
  INDEX `fk_artista_has_obra_obra1_idx` (`obra_id` ASC),
  INDEX `fk_artista_has_obra_artista1_idx` (`artista_id` ASC),
  CONSTRAINT `fk_artista_has_obra_artista1`
    FOREIGN KEY (`artista_id`)
    REFERENCES `websiteartes`.`artista` (`id_artista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_artista_has_obra_obra1`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`obra_has_genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`obra_has_genero` (
  `obra_id` INT(11) NOT NULL,
  `genero_id` INT(11) NOT NULL,
  PRIMARY KEY (`obra_id`, `genero_id`),
  INDEX `fk_obra_has_genero_genero1_idx` (`genero_id` ASC),
  INDEX `fk_obra_has_genero_obra1_idx` (`obra_id` ASC),
  CONSTRAINT `fk_obra_has_genero_obra1`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_obra_has_genero_genero1`
    FOREIGN KEY (`genero_id`)
    REFERENCES `websiteartes`.`genero` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `websiteartes`.`cmt_artista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`cmt_artista` (
  `id_cmt_artista` INT NOT NULL AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `noLikes` INT NOT NULL DEFAULT 0,
  `artista_id` INT(11),
  `usuario_id` INT(11),
  PRIMARY KEY (`id_cmt_artista`),
  FOREIGN KEY (`artista_id`) REFERENCES `websiteartes`.`artista` (`id_artista`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `websiteartes`.`cmt_obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`cmt_obra` (
  `id_cmt_obra` INT NOT NULL AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `noLikes` INT NOT NULL DEFAULT 0,
  `obra_id` INT(11),
  `usuario_id` INT(11),
  PRIMARY KEY (`id_cmt_obra`),
  FOREIGN KEY (`obra_id`) REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `websiteartes`.`nivel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`nivel` (
  `id_nivel` INT NOT NULL,
  `descricao` VARCHAR(150) NOT NULL,
  `pontuacaoInicial` INT NOT NULL,
  `pontuacaoFinal` INT NOT NULL,
  PRIMARY KEY (`id_nivel`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `websiteartes`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`usuario` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL UNIQUE,
  `senha` VARCHAR(150) NOT NULL,
  `img_perfil` VARCHAR(250) NULL DEFAULT NULL,
  `data_nasc` DATE NULL DEFAULT NULL,
  `email` VARCHAR(150) NOT NULL,
  `ativo` TINYINT(4),
  `validador` VARCHAR(45),
  `data_criacaoConta` DATE NOT NULL,
  `sobre_mim` TEXT,
  `ultimoLogin` DATETIME NULL,
  `adm` TINYINT NULL DEFAULT 0,
  `pontuacao` INT,
  `nivel_id` INT,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_usuario_nivel1_idx` (`nivel_id` ASC),
  CONSTRAINT `fk_usuario_nivel1`
    FOREIGN KEY (`nivel_id`)
    REFERENCES `websiteartes`.`nivel` (`id_nivel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `websiteartes`.`lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`lista` (
  `id_lista` INT(11) NOT NULL AUTO_INCREMENT,
  `autor` INT(11) NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `nome` VARCHAR(128) NOT NULL,
  `descricao` TEXT NULL,
  `privacidade` SMALLINT NULL,
  `ordenacao` TINYINT NOT NULL COMMENT 'Ordenada ou não-ordenada',
  PRIMARY KEY (`id_lista`),
  INDEX `autor` (`autor` ASC),
  CONSTRAINT `lista_ibfk_1`
    FOREIGN KEY (`autor`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
		ON DELETE CASCADE
        ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`item` (
  `id_item` INT(11) NOT NULL AUTO_INCREMENT,
  `lista` INT(11) NOT NULL,
  `obra` INT(11) NULL,
  `artista` INT(11) NULL,
  `descricao` TEXT NULL,
  `posicao` INT(11) NULL,
  PRIMARY KEY (`id_item`),
  INDEX `lista` (`lista` ASC),
  INDEX `obra` (`obra` ASC),
  INDEX `artista` (`artista` ASC),
  CONSTRAINT `item_ibfk_1`
    FOREIGN KEY (`lista`)
    REFERENCES `websiteartes`.`lista` (`id_lista`)
		ON UPDATE CASCADE
        ON DELETE CASCADE,
  CONSTRAINT `item_ibfk_2`
    FOREIGN KEY (`obra`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
		ON UPDATE CASCADE
        ON DELETE CASCADE,
  CONSTRAINT `item_ibfk_3`
    FOREIGN KEY (`artista`)
    REFERENCES `websiteartes`.`artista` (`id_artista`)
		ON UPDATE CASCADE
        ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `websiteartes`.`cmt_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`cmt_lista` (
  `id_cmt_lista` INT NOT NULL AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `noLikes` INT NOT NULL DEFAULT 0,
  `lista_id` INT(11),
  `usuario_id` INT(11),
  PRIMARY KEY (`id_cmt_lista`),
  FOREIGN KEY (`lista_id`) REFERENCES `websiteartes`.`lista` (`id_lista`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`resenha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`resenha` (
  `id_resenha` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `obra_id` INT(11) NOT NULL,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  PRIMARY KEY (`id_resenha`),
  INDEX `autor` (`usuario_id` ASC),
  INDEX `obra` (`obra_id` ASC),
  CONSTRAINT `resenha_ibfk_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`),
  CONSTRAINT `resenha_ibfk_2`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `websiteartes`.`cmt_resenha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`cmt_resenha` (
  `id_cmt_resenha` INT NOT NULL AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `noLikes` INT NOT NULL DEFAULT 0,
  `resenha_id` INT(11),
  `usuario_id` INT(11),
  PRIMARY KEY (`id_cmt_resenha`),
  FOREIGN KEY (`resenha_id`) REFERENCES `websiteartes`.`resenha` (`id_resenha`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`notificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`notificacao` (
  `id_notif` INT NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`id_notif`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`cmt_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`cmt_usuario` (
  `id_cmt_usuario` INT NOT NULL AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  `noLikes` INT NOT NULL DEFAULT 0,
  `usuario_id` INT(11),
  `usuario_comentado_id` INT(11),
  PRIMARY KEY (`id_cmt_usuario`),
  FOREIGN KEY (`usuario_comentado_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`config_privacidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`config_privacidade` (
  `id_usuario` INT(11) NOT NULL,
  `mostrar_nome` SMALLINT NOT NULL,
  `mostrar_DMA_nasc` SMALLINT NOT NULL COMMENT 'DMA: data, mês e ano',
  `mostrar_DM_nasc` SMALLINT NOT NULL COMMENT 'DM: data e mês. Para caso o usuário queira mostrar qual seu aniversário mas não qual sua idade.',
  `mostrar_email` SMALLINT NOT NULL,
  `mostrar_celular` SMALLINT NOT NULL,
  `mostrar_sobreMim` SMALLINT NOT NULL,
  `mostrar_favArtistas` SMALLINT NOT NULL,
  `mostrar_favObras` SMALLINT NOT NULL,
  `mostrar_obrasEstados` SMALLINT NOT NULL COMMENT 'estados \"quero ler/ouvir/assistir\", \"já li/ouvi/assisti\", \"estou lendo/ouvindo/assistindo\" etc.',
  INDEX `fk_config_privacidade_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_config_privacidade_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `websiteartes`.`msgPrivadaThread`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`msgPrivadaThread` (
	`id_thread` INT PRIMARY KEY AUTO_INCREMENT,
    `titulo` VARCHAR(255)
);

-- -----------------------------------------------------
-- Table `websiteartes`.`msgUsuariosThread`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`msgUsuariosThread` (
	`thread_id` INT NOT NULL,
    `usuario_id` INT NOT NULL,
    PRIMARY KEY (`thread_id`, `usuario_id`),
    FOREIGN KEY (`thread_id`) REFERENCES `msgPrivadaThread`(`id_thread`)
		ON UPDATE CASCADE
        ON DELETE CASCADE,
	FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id_usuario`)
		ON UPDATE CASCADE
        ON DELETE CASCADE
);
-- -----------------------------------------------------
-- Table `websiteartes`.`msgPrivada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`msgPrivada` (
  `id_msg` INT NOT NULL AUTO_INCREMENT,
  `thread_id` INT NOT NULL,
  `usuario_id` INT,
  `texto` TEXT NOT NULL,
  `dtHr` DATETIME NOT NULL,
  PRIMARY KEY (`id_msg`),
  FOREIGN KEY (`thread_id`) REFERENCES `msgPrivadaThread`(`id_thread`)
	ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`id_usuario`)
	ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`tipo_con`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`tipo_con` (
  `id_tipo` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id_tipo`))
ENGINE = InnoDB;
INSERT INTO `tipo_con` (`id_tipo`, `descricao`) VALUES
(1, 'Remoção'),
(2, 'Atualização'),
(3, 'Nova entidade');


-- -----------------------------------------------------
-- Table `websiteartes`.`estado_con`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`estado_con` (
  `id_estado` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id_estado`))
ENGINE = InnoDB;
INSERT INTO `estado_con` (`id_estado`, `descricao`)
VALUES (1, 'Esperando avaliação'), (2, 'Rejeitada'), (3, 'Pode melhorar'), (4, 'A implementar'), (5, 'Implementada');

-- -----------------------------------------------------
-- Table `websiteartes`.`contribuicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`contribuicao` (
  `id_contribuicao` INT NOT NULL AUTO_INCREMENT,
  `informacao` TEXT NOT NULL,
  `fontes` TEXT NOT NULL,
  `artista_id` INT(11),
  `genero_id` INT(11),
  `obra_id` INT(11),
  `linguagensart_id` INT(11),
  `tipo_con_id` INT,
  `estado_con_id` INT DEFAULT 1,
  `adm_usuario_id` INT(11),
  `adm_comentario` TEXT COMMENT 'Comentário de um administrador que explica porque a informação recebeu determinado estado (ex: estado:\"Rejeitada\", comentario:\"Fontes não confiáveis\")',
  `usuario_id` INT(11),
  PRIMARY KEY (`id_contribuicao`),
  INDEX `fk_contribuicao_artista1_idx` (`artista_id` ASC),
  INDEX `fk_contribuicao_genero1_idx` (`genero_id` ASC),
  INDEX `fk_contribuicao_obra1_idx` (`obra_id` ASC),
  INDEX `fk_contribuicao_linguagensart1_idx` (`linguagensart_id` ASC),
  INDEX `fk_contribuicao_tipo_con1_idx` (`tipo_con_id` ASC),
  INDEX `fk_contribuicao_estado_con1_idx` (`estado_con_id` ASC),
  INDEX `fk_contribuicao_usuario1_idx` (`adm_usuario_id` ASC),
  INDEX `fk_contribuicao_usuario2_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_contribuicao_artista1`
    FOREIGN KEY (`artista_id`)
    REFERENCES `websiteartes`.`artista` (`id_artista`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_genero1`
    FOREIGN KEY (`genero_id`)
    REFERENCES `websiteartes`.`genero` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_obra1`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_linguagensart1`
    FOREIGN KEY (`linguagensart_id`)
    REFERENCES `websiteartes`.`linguagensart` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_tipo_con1`
    FOREIGN KEY (`tipo_con_id`)
    REFERENCES `websiteartes`.`tipo_con` (`id_tipo`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_estado_con1`
    FOREIGN KEY (`estado_con_id`)
    REFERENCES `websiteartes`.`estado_con` (`id_estado`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_usuario1`
    FOREIGN KEY (`adm_usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contribuicao_usuario2`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `websiteartes`.`relacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`relacao` (
  `id_relacao` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NULL,
  `votos` INT NULL,
  `fontes` TEXT NULL,
  `obra1_id` INT(11) NULL,
  `obra2_id` INT(11) NULL,
  `artista1_id` INT(11) NULL,
  `artista2_id` INT(11) NULL,
  `genero1_id` INT(11) NULL,
  `genero2_id` INT(11) NULL,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id_relacao`),
  FOREIGN KEY (`obra1_id`) REFERENCES `websiteartes`.`obra` (`id_obra`),
  FOREIGN KEY (`obra2_id`) REFERENCES `websiteartes`.`obra` (`id_obra`),
  FOREIGN KEY (`artista1_id`) REFERENCES `websiteartes`.`artista` (`id_artista`),
  FOREIGN KEY (`artista2_id`) REFERENCES `websiteartes`.`artista` (`id_artista`),
  FOREIGN KEY (`genero1_id`) REFERENCES `websiteartes`.`genero` (`id`),
  FOREIGN KEY (`genero2_id`) REFERENCES `websiteartes`.`genero` (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `websiteartes`.`usuario` (`id_usuario`))
ENGINE = InnoDB;

/*
-- -----------------------------------------------------
-- Table `websiteartes`.`usuario_has_notificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`usuario_has_notificacao` (
  `usuario_id` INT(11) NOT NULL,
  `notificacao_id_notif` INT NOT NULL,
  PRIMARY KEY (`usuario_id`, `notificacao_id_notif`),
  INDEX `fk_usuario_has_notificacao_notificacao1_idx` (`notificacao_id_notif` ASC),
  INDEX `fk_usuario_has_notificacao_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_notificacao_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_notificacao_notificacao1`
    FOREIGN KEY (`notificacao_id_notif`)
    REFERENCES `websiteartes`.`notificacao` (`id_notif`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

*/
-- -----------------------------------------------------
-- Table `websiteartes`.`amizade_pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`amizade_pedido` (
  `user1_id` INT(11) NOT NULL,
  `user2_id` INT(11) NOT NULL,
  PRIMARY KEY (`user1_id`, `user2_id`),
  INDEX `fk_usuario_has_usuario2_usuario2_idx` (`user2_id` ASC),
  INDEX `fk_usuario_has_usuario2_usuario1_idx` (`user1_id` ASC),
  CONSTRAINT `fk_usuario_has_usuario2_usuario1`
    FOREIGN KEY (`user1_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_has_usuario2_usuario2`
    FOREIGN KEY (`user2_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`amizade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`amizade` (
  `user1_id` INT(11) NOT NULL,
  `user2_id` INT(11) NOT NULL,
  PRIMARY KEY (`user1_id`, `user2_id`),
  INDEX `fk_usuario_has_usuario_usuario2_idx` (`user2_id` ASC),
  INDEX `fk_usuario_has_usuario_usuario1_idx` (`user1_id` ASC),
  CONSTRAINT `fk_usuario_has_usuario_usuario1`
    FOREIGN KEY (`user1_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario_has_usuario_usuario2`
    FOREIGN KEY (`user2_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`usuario_relacao_obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`usuario_relacao_obra` (
  `usuario_id` INT(11) NOT NULL,
  `obra_id` INT(11) NOT NULL,
  `relacao` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`usuario_id`, `obra_id`),
  INDEX `fk_usuario_has_obra_obra1_idx` (`obra_id` ASC),
  INDEX `fk_usuario_has_obra_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_obra_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_obra_obra1`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`obras_favoritas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`obras_favoritas` (
  `usuario_id` INT(11) NOT NULL,
  `obra_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`, `obra_id`),
  INDEX `fk_usuario_has_obra_obra2_idx` (`obra_id` ASC),
  INDEX `fk_usuario_has_obra_usuario2_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_obra_usuario2`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_obra_obra2`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `websiteartes`.`artistas_favoritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`artistas_favoritos` (
  `usuario_id` INT(11) NOT NULL,
  `artista_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`, `artista_id`),
  INDEX `fk_usuario_has_artista_artista1_idx` (`artista_id` ASC),
  INDEX `fk_usuario_has_artista_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_artista_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_artista_artista1`
    FOREIGN KEY (`artista_id`)
    REFERENCES `websiteartes`.`artista` (`id_artista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `websiteartes`.`usuario_nota_obra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `websiteartes`.`usuario_nota_obra` (
  `usuario_id` INT(11) NOT NULL,
  `obra_id` INT(11) NOT NULL,
  `nota` INT NOT NULL,
  PRIMARY KEY (`usuario_id`, `obra_id`),
  INDEX `fk_usuario_has_obra_obra3_idx` (`obra_id` ASC),
  INDEX `fk_usuario_has_obra_usuario3_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_obra_usuario3`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `websiteartes`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_obra_obra3`
    FOREIGN KEY (`obra_id`)
    REFERENCES `websiteartes`.`obra` (`id_obra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
