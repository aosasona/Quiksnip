<?php

namespace Quiksnip\Web\Utils;

use Quiksnip\Web\Exceptions\HTTPException;

class Validator
{
	/**
	 * @throws HTTPException
	 */
	public static function checkNullFields(array $data, array $fields): void
	{
		foreach ($fields as $field) {
			if (!isset($data[$field])) {
				$field = ucfirst(str_replace("_", " ", $field));
				$msg = "{$field} is required!";
				throw new HTTPException($msg, 400);
			}
		}
	}


	/**
	 * @throws HTTPException
	 */
	public static function validateMinLength(string $str, string $field_name, int $min): bool
	{
		if (strlen($str) > $min) {
			return true;
		} else {
			throw new HTTPException("{$field_name} must be at least {$min} characters long!", 400);
		}
	}
}