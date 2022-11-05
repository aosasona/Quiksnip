ALTER TABLE `users`
    ADD `name`       VARCHAR(255) NOT NULL AFTER `id`,
    ADD `bio`        TEXT         NOT NULL AFTER `username`,
    ADD `last_login` DATETIME     NOT NULL DEFAULT NOW() AFTER `updated_at`,
    ADD `github_url` VARCHAR(255) AFTER `profile_image`;