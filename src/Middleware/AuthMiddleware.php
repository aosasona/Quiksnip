<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Models\Snippet;
use Quiksnip\Web\Services\Auth;
use Quiksnip\Web\Services\Session;
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

		if (isset($_GET["_key"])) {
			$_SESSION["is_guest"] = false;
			$_SESSION["auth_token"] = $_SESSION["_key"] = $_GET["_key"];
			$_SESSION["user"] = [
				"id" => 0,
				"name" => "Elevated Guest",
				"bio" => "",
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
		$user = Auth::getSessionUser();
		$snippet = new Snippet();
		$snippet_data = $snippet->selectOne("SELECT owner_id, whitelist, is_public FROM snippets WHERE slug = ? LIMIT 1", [$slug]);

		if ($snippet_data["is_public"]) return;
		if (self::isLoggedIn() && $snippet_data["owner_id"] == $user["id"]) return;
		if (self::isLoggedIn() && in_array(strtolower($user["email"] ?? "---"), explode(",", $snippet_data["whitelist"] ?? ""))) return;
		if ($session_key && Session::validateSession($session_key)) return;

		require __DIR__ . "/../401.php";
		exit;
	}
}
