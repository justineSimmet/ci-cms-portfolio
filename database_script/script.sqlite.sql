DROP TABLE IF EXISTS `parameter`;

CREATE TABLE `parameter` (
  `id`  INTEGER NOT NULL,
  `site_name` INTEGER NOT NULL,
  `site_description` INTEGER NOT NULL,
  `site_author`  INTEGER NOT NULL,
  PRIMARY KEY(`id`)
);

INSERT INTO `parameter`(`site_name`,`site_description`, `site_author`) VALUES
                       ('YOUR SITE NAME','YOUR SITE description', 'SITE AUTHOR');

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id`  INTEGER NOT NULL,
  `username`  INTEGER NOT NULL,
  `password`  TEXT NOT NULL,
  `email` TEXT NOT NULL,
  `last_login`  INTEGER DEFAULT NULL,
  `first_name`  TEXT DEFAULT NULL,
  `last_name` TEXT DEFAULT NULL,
  `is_admin`  INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`)
);

INSERT INTO `user`(`username`,`password`,`email`,`first_name`,`last_name`,`is_admin`) VALUES
                  ('administrator','$2y$10$h7gqcVrewud8AZ4UnCKzx.HaSSBnPyG0M3MFZ6m/Ycp7bX2Fbc7gS','admin@example.com','admin','istrator','1');

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id`  TEXT NOT NULL,
  `ip_address`  TEXT NOT NULL,
  `timestamp` INTEGER NOT NULL DEFAULT 0,
  `data`  BLOB NOT NULL,
  PRIMARY KEY(`id`,`ip_address`)
);

CREATE INDEX "ci_sessions_timestamp" ON "ci_sessions" ("timestamp");

DROP TABLE IF EXISTS `project_category`;

CREATE TABLE `project_category` (
  `id`  INTEGER NOT NULL,
  `title` TEXT NOT NULL,
  `visibility`  INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`)
);

INSERT INTO `project_category`(`title`,`visibility`) VALUES('unassigned',0);

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id`  INTEGER NOT NULL,
  `title` TEXT NOT NULL,
  `context` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `external_link` TEXT DEFAULT NULL,
  `public_url`  TEXT NOT NULL,
  `category_id` INTEGER NOT NULL DEFAULT 1,
  `visibility`  INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`category_id`) REFERENCES `project_category`(`id`) ON DELETE SET DEFAULT ON UPDATE NO ACTION
);


DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `id`  INTEGER NOT NULL,
  `title` TEXT NOT NULL,
  `alt` TEXT NOT NULL,
  `filename`  TEXT NOT NULL,
  `gallery_order` INTEGER,
  `project_id`  INTEGER NOT NULL,
  `visibility`  INTEGER NOT NULL DEFAULT 1,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`project_id`) REFERENCES `project`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE INDEX "ci_sessions_timestamp" ON `ci_sessions`(`timestamp`);
CREATE INDEX `fk_picture_project_id` ON `picture`(`project_id`);
CREATE INDEX `fk_project_category_id` ON `project`(`category_id`);
CREATE INDEX `index_public_url` ON `project` (`public_url`);

CREATE TRIGGER trigger_hide_child_project 
  AFTER UPDATE ON project_category WHEN NEW.visibility IS 0 
BEGIN
  UPDATE project
  SET visibility=0
  WHERE category_id = NEW.id;
END;

CREATE TRIGGER trigger_set_order
  AFTER INSERT ON picture WHEN NEW.gallery_order IS NULL
BEGIN
  UPDATE picture
  SET gallery_order= IFNULL((SELECT MAX(gallery_order) FROM picture
  WHERE project_id = NEW.project_id) +1, 0)
  WHERE id = NEW.id;
END;