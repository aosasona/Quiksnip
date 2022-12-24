<?php

namespace Quiksnip\Web\Utils;


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

	public static function generateSessionKey(int $length = 16)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$chars_array = explode("", $chars);
	}
}
