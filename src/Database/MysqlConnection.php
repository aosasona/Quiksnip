<?php

namespace Quiksnip\Web\Database;

use PDO;
use PDOException;
use Quiksnip\Web\Exceptions\{ConnectionException};

class MysqlConnection extends Connection
{
	private string $dsn;
	private PDO $pdo;
	protected array $options;


	/**
	 * @throws ConnectionException
	 */
	public function __construct()
	{
		extract($_ENV);
		$host = $MYSQL_HOST;
		$port = $MYSQL_PORT;
		$user = $MYSQL_USER;
		$pass = $MYSQL_PASSWORD;
		$db = $MYSQL_DATABASE;

		$database_config = [
			'host' => $host,
			'port' => $port,
			'user' => $user,
			'pass' => $pass,
			'db' => $db
		];

		$this->dsn = $this->buildDSN($database_config);

		$this->options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		$this->pdo = $this->connect($user, $pass);
	}


	private function buildDSN(array $data): string
	{
		return "mysql:host={$data['host']};port={$data['port']};dbname={$data['db']}";
	}


	/**
	 * @throws ConnectionException
	 */
	private function connect(string $username, string $password): PDO
	{
		try {
			$this->pdo = new PDO($this->dsn, $username, $password, $this->options);
			return $this->pdo;
		} catch (PDOException $e) {
			throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
		}
	}


	public function getConnection(): PDO
	{
		return $this->pdo;
	}

}