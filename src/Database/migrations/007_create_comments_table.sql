CREATE TABLE IF NOT EXISTS `comments`
(
    id         SERIAL PRIMARY KEY NOT NULL AUTO_INCREMENT UNIQUE,
    comment    TEXT               NOT NULL,
    up_votes   INT                NOT NULL DEFAULT 0,
    down_votes INT                NOT NULL DEFAULT 0,
    user_id    INT                         DEFAULT NULL REFERENCES users (id),
    snippet_id INT                         DEFAULT NULL REFERENCES snippets (id),
    created_at TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP
)