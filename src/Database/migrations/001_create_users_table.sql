CREATE TABLE IF NOT EXISTS users
(
    id          SERIAL PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    username    VARCHAR(255)                      NOT NULL,
    email       VARCHAR(255)                      NOT NULL,
    auth_source VARCHAR(255),
    created_at  TIMESTAMP                         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP                         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;