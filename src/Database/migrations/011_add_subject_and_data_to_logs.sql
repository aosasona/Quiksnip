ALTER TABLE `logs`
    ADD `subject` VARCHAR(255) NOT NULL AFTER `id`,
    ADD `data`    TEXT         NOT NULL AFTER `event`;