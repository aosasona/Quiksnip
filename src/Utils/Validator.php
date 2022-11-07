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
}