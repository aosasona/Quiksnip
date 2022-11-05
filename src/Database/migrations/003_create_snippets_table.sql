CREATE TABLE IF NOT EXISTS snippets
(
    id             SERIAL PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    title          TEXT,
    lang           VARCHAR(255),
    content        TEXT,
    slug           VARCHAR(255) UNIQUE,
    is_public      BOOLEAN   DEFAULT TRUE,
    allow_comments BOOLEAN   DEFAULT TRUE,
    allow_edit     BOOLEAN   DEFAULT TRUE,
    up_votes       INT       DEFAULT 0,
    down_votes     INT       DEFAULT 0,
    owner_id       INT       DEFAULT NULL REFERENCES `users` (id) ON DELETE SET NULL ON UPDATE CASCADE,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);