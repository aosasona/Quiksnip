<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Utils\Auth;
use Trulyao\PhpRouter\HTTP\Request;
use Trulyao\PhpRouter\HTTP\Response;

class AuthMiddleware
{
	public function __construct()
	{
	}


	public static function isLoggedIn(): bool
	{
		return Auth::isLoggedIn();
	}


	public static function protect(Request $request, Response $response): void
	{
		if (!self::isLoggedIn()) {
			$response->redirect("/auth");
			return;
		}

		$request->append("user", Auth::getSessionUser());
		return;
	}


	public static function redirectIfLoggedIn(Request $request, Response $response): void
	{
		if (self::isLoggedIn()) {
			$response->redirect("/explore");
			return;
		}
	}

}