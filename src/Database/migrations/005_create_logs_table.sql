CREATE TABLE IF NOT EXISTS logs
(
    id         SERIAL PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    `event`    ENUM ('access', 'edit', 'share')  NOT NULL,
    user_id    INT       DEFAULT NULL REFERENCES users (id),
    snippet_id INT       DEFAULT NULL REFERENCES snippets (id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);