<?php

namespace Quiksnip\Quiksnip\Models;

use Quiksnip\Quiksnip\Database\Database;

abstract class BaseModel
{
	protected Database $db;
	protected string $table;

	public function __construct()
	{
		$this->db = new Database();
		$this->table = $this->getTableName();
	}

	public function getTableName(): string
	{
		$class_name = (new \ReflectionClass($this))->getShortName();
		$model_name = "{$class_name}s";
		return strtolower($model_name);
	}

	public function __get($name)
	{
		return $this->{$name};
	}

	public function __set($name, $value)
	{
		$this->{$name} = $value;
	}

	public function select(string $query, array $params = []): array
	{
		return $this->db->select($query, $params);
	}

	public function findOne($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE `id` = :id LIMIT 1";
		$params = [
			":id" => $id
		];

		$result = $this->db->query($query, $params);

		if ($result->rowCount() > 0) {
			return $result->fetch();
		}

		return NULL;
	}

	public function query(string $query, array $params = []): bool | \PDOStatement
	{
		return $this->db->query($query, $params);
	}

	public function find(): bool | array | null
	{
		$query = "SELECT * FROM {$this->table}";
		$params = [];

		$result = $this->db->query($query, $params);

		if ($result->rowCount() > 0) {
			return $result->fetchAll();
		}

		return NULL;
	}

	public function delete(): ?bool
	{
		$query = "DELETE FROM {$this->table} WHERE `id` = :id";
		$params = [
			":id" => $this->id
		];

		$result = $this->db->query($query, $params);

		if ($result->rowCount() > 0) {
			return TRUE;
		}

		return NULL;
	}

	public function save(): bool | string | null
	{
		if (isset($this->id)) {
			return $this->update();
		}

		return $this->create();
	}

	public function update(): ?bool
	{
		$query = "UPDATE {$this->table} SET ";
		$params = [];

		foreach ($this as $key => $value) {
			if ($key === "db" || $key === "table") {
				continue;
			}

			$query .= "`{$key}` = :{$key}, ";
			$params[":{$key}"] = $value;
		}

		$query = rtrim($query, ", ");
		$query .= " WHERE `id` = :id";

		$result = $this->db->query($query, $params);

		if ($result->rowCount() > 0) {
			return TRUE;
		}

		return NULL;
	}

	public function create(): bool | string | null
	{
		$query = "INSERT INTO {$this->table} (";
		$params = [];

		foreach ($this as $key => $value) {
			if ($key === "db" || $key === "table") {
				continue;
			}

			$query .= "`{$key}`, ";
			$params[":{$key}"] = $value;
		}

		$query = rtrim($query, ", ");
		$query .= ") VALUES (";

		foreach ($params as $key => $value) {
			$query .= "{$key}, ";
		}

		$query = rtrim($query, ", ");
		$query .= ")";

		$result = $this->db->query($query, $params);

		if ($result->rowCount() > 0) {
			return $this->db->getConnection()->lastInsertId();
		}

		return NULL;
	}

	public function beginTransaction(): bool
	{
		return $this->db->getConnection()->beginTransaction();
	}

	public function commit(): bool
	{
		return $this->db->getConnection()->commit();
	}

	public function rollBack(): bool
	{
		return $this->db->getConnection()->rollBack();
	}

}