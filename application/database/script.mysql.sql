DROP TABLE IF EXISTS `parameter`;

CREATE TABLE `parameter` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `site_name` tinytext NOT NULL,
  `site_description` text NOT NULL,
  `site_author` varchar(140) NOT NULL,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB;

INSERT INTO `parameter`(`site_name`,`site_description`, `site_author`) VALUES
                       ('YOUR SITE NAME','YOUR SITE description', 'SITE AUTHOR');

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id`  smallint unsigned NOT NULL AUTO_INCREMENT,
  `username`  varchar(40) NOT NULL,
  `password`  varchar(60) NOT NULL,
  `email` varchar(80) NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `first_name`  varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `is_admin`  boolean NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`)
)ENGINE=MYISAM;

INSERT INTO `user`(`username`,`password`,`email`,`first_name`,`last_name`,`is_admin`) VALUES
                  ('administrator','$2y$10$h7gqcVrewud8AZ4UnCKzx.HaSSBnPyG0M3MFZ6m/Ycp7bX2Fbc7gS','admin@example.com','admin','istrator',1);

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
)ENGINE=MYISAM;

ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address);


DROP TABLE IF EXISTS `project_category`;

CREATE TABLE `project_category` (
  `id`  smallint unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `visibility`  boolean NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB;

INSERT INTO `project_category`(`title`,`visibility`) VALUES('unassigned',0);

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id`  integer unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `context` text NOT NULL,
  `description` text NOT NULL,
  `external_link` text DEFAULT NULL,
  `public_url`  varchar(255) NOT NULL,
  `category_id` smallint unsigned NOT NULL,
  `visibility`  boolean NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`category_id`)
    REFERENCES `project_category`(`id`)
)ENGINE=InnoDB;


DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `id`  integer unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `alt` text NOT NULL,
  `filename`  tinytext NOT NULL,
  `gallery_order` tinyint unsigned NULL,
  `project_id`  integer unsigned NOT NULL,
  `visibility`  boolean NOT NULL DEFAULT 1,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`project_id`) 
    REFERENCES `project`(`id`) 
    ON UPDATE NO ACTION 
    ON DELETE CASCADE
)ENGINE=InnoDB;


CREATE INDEX `index_public_url` ON `project` (`public_url`);

DROP TRIGGER IF EXISTS project_category_after_update;

DELIMITER $$

CREATE TRIGGER project_category_after_update AFTER UPDATE
  ON project_category FOR EACH ROW
BEGIN
  IF NEW.visibility = 0 THEN
    UPDATE project
    SET visibility = 0
    WHERE category_id = NEW.id;
  END IF;
END$$

DELIMITER ;


DROP TRIGGER IF EXISTS project_category_before_delete;

DELIMITER $$

CREATE TRIGGER project_category_before_delete BEFORE DELETE
  ON project_category FOR EACH ROW
BEGIN
  UPDATE project
  SET category_id = 1
  WHERE category_id = OLD.id ;
END$$

DELIMITER ;

DROP TRIGGER IF EXISTS picture_after_insert;

DELIMITER $$

CREATE TRIGGER picture_before_insert BEFORE INSERT
  ON picture FOR EACH ROW
BEGIN
  IF NEW.gallery_order IS NULL THEN
    SET NEW.gallery_order = ((SELECT MAX(`gallery_order`) FROM picture WHERE project_id = NEW.project_id)+ 1);
  END IF;
END$$

DELIMITER ;