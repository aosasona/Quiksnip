ALTER TABLE `users`
    ADD COLUMN `role` ENUM ('admin', 'mod', 'user') NOT NULL DEFAULT 'user' AFTER `email`;