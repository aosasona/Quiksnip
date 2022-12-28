CREATE TABLE IF NOT EXISTS `requests`
(
    `id`         SERIAL      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ip_address` VARCHAR(64) NOT NULL,
    `path`       VARCHAR(64),
    `_get`       TEXT,
    `_post`      TEXT,
    `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
