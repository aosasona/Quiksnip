ALTER TABLE `logs`
    MODIFY COLUMN `event` VARCHAR(255) NOT NULL DEFAULT 'unknown';