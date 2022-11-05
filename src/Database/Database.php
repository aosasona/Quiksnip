<?php

namespace Quiksnip\Quiksnip\Database;

use PDO;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = (new MysqlConnection())->getConnection();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function query(string $query, array $params = []): bool|\PDOStatement
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    public function select(string $query, array $params = []): array
    {
        $statement = $this->query($query, $params);
        return $statement->fetchAll();
    }

    public function migrate(): void
    {
        $dir = __DIR__ . "/migrations";
        $files = scandir($dir);
        $files = array_diff($files, ['.', '..']);

        usort($files, function ($a, $b) {
            return (int)explode("_", $a)[0] <=> (int)explode("_", $b)[0];
        });

        $this->query("CREATE TABLE IF NOT EXISTS `migrations` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `name` VARCHAR(255) NOT NULL,
                        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
                        ENGINE=INNODB;");

        $all_migrations = $this->select("SELECT * FROM `migrations`");
        $count = count($all_migrations);
        if ($count === count($files)) {
            return;
        }

        foreach ($files as $file) {
            $file_name = explode('.', $file)[0];
            $has_run = $this->select("SELECT * FROM `migrations` WHERE `name` = ?", [$file_name]);
            if (count($has_run) > 0) {
                continue;
            }
            $sql = file_get_contents($dir . "/" . $file);
            $this->query($sql);
            $this->query("INSERT INTO `migrations` (`name`) VALUES (?)", [$file_name]);
        }
    }
}