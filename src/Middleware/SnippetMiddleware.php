<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Models\Snippet;
use Trulyao\PhpRouter\HTTP\{Request, Response};

class SnippetMiddleware
{
	public static function fetchSnippet(Request $request, Response $response,)
	{
		$slug = $request->params("slug");
		$snippet = new Snippet();
		$data = $snippet->selectOne("SELECT `p`.*, `l`.`event`, `l`.`user_id` AS `log_uid`, `l`.`created_at`, `c`.*, `u`.`name` AS `u_name`, `u`.`username` AS `u_username`, `u`.`profile_image` AS `u_image`, `u`.`github_url` AS `u_link` FROM `snippets` p LEFT JOIN `users` u ON `p`.`owner_id` = `u`.`id` LEFT JOIN `logs` l ON `u`.id = `l`.snippet_id LEFT JOIN `comments` c ON `u`.id = `c`.snippet_id WHERE slug = :slug", ["slug" => $slug]);
		$request->append("snippet_data", $data);
	}
}