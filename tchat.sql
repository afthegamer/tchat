CREATE TABLE IF NOT EXISTS `message` (
  `m_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `m_content` TEXT NOT NULL,
  `m_create_at` DATETIME NULL,
  `m_username` VARCHAR(45) NULL,
  PRIMARY KEY (`m_id`))
ENGINE = InnoDB;