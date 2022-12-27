<?php

namespace Quiksnip\Web\Utils;


class Auth
{
	public static function getSessionUser(): array|null
	{
		if (self::isLoggedIn()) {
			return $_SESSION["user"];
		}

		return null;
	}


	public static function isLoggedIn(): bool
	{
		return isset($_SESSION["user"]) || isset($_SESSION["auth_token"]);
	}


	public static function logout(): void
	{
		unset($_SESSION["user"], $_SESSION["auth_token"], $_SESSION["is_guest"]);
	}


	public static function isGuest(): bool
	{
		return isset($_SESSION["is_guest"]);
	}

	public static function generateSessionKey(int $length = 24): string
	{
		$chars = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890", 1);
		$key = "";
		for ($i = 0; $i < $length; $i++) {
			$key .= $chars[array_rand($chars, 1)];
		}
		return $key;
	}
}
