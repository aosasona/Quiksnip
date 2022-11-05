<?php

namespace Quiksnip\Quiksnip\Utils;


class Auth
{
	public static function getSessionUser()
	{
		if (self::isLoggedIn()) {
			return $_SESSION["user"];
		}

		return null;
	}


	public static function isLoggedIn(): bool
	{
		return isset($_SESSION["user"]);
	}


	public static function logout(): void
	{
		unset($_SESSION["user"]);
	}
}