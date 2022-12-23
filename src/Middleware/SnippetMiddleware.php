<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Models\Snippet;
use Quiksnip\Web\Utils\Logger;
use Quiksnip\Web\Utils\Misc;
use Trulyao\PhpRouter\HTTP\{Request, Response};

class SnippetMiddleware
{
	public static function fetchSnippet(Request $request, Response $response,): void
	{
		$slug = $request->params("slug");
		$snippet = new Snippet();
		$snippet_data = $snippet->selectOne("SELECT `p`.*, `u`.`name` AS `u_name`, `u`.`username` AS `u_username`, `u`.`profile_image` AS `u_image`, `u`.`github_url` AS `u_link` FROM `snippets` p LEFT JOIN `users` u ON `p`.`owner_id` = `u`.`id` WHERE slug = :slug", ["slug" => $slug]);
		$snipped_log_data = $snippet->selectMany("SELECT * FROM `logs` WHERE `snippet_id` = :id", ["id" => $snippet_data["id"]]);
		$snippet_comments = $snippet->selectMany("SELECT * FROM `comments` WHERE `snippet_id` = :id", ["id" => $snippet_data["id"]]);
		$request->append("snip_data", $snippet_data);
		$request->append("snip_logs", $snipped_log_data);
		$request->append("snip_comments", $snippet_comments);
		$data = json_encode([
			"id" => $snippet_data["id"],
			"slug" => $snippet_data["slug"],
			"user" => $_SESSION["user"]["id"] ?? $request->query("_key") ?? "",
			"logged_in" => (bool)$_SESSION["user"]["id"],
			"created_at" => Misc::formatDateTime(),
		]);

		Logger::logEvent($snippet_data["id"], Logger::VIEWED, $data);
	}
}

