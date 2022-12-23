<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Models\Snippet;
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
		if (!self::isLoggedIn() && !isset($_GET["session_key"])) {
			$response->redirect("/auth");
			return;
		}

		if (isset($_GET["session_key"])) {
			$_SESSION["is_guest"] = true;
			$_SESSION["auth_token"] = $_GET["session_key"];
			$_SESSION["user"] = [
				"id" => 0,
				"name" => "guest",
				"bio" => "guest",
				"username" => "guest",
				"email" => "guest",
				"profile_image" => "",
				"github_url" => ""
			];
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

	public static function validateSnippetAccess(Request $request, Response $response): void
	{
		$session_key = $request->query("_key");
		$slug = $request->params("slug");

		$snippet = new Snippet();
		$snippet_data = $snippet->selectOne("SELECT owner_id, is_public FROM snippets WHERE slug = ? LIMIT 1", [$slug]);

		// if(self::isLoggedIn() && ) return;
	}
}

