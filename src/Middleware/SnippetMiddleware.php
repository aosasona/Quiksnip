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
		$data = $snippet->selectOne("SELECT `p`.*, `u`.`name` AS `u_name`, `u`.`username` AS `u_username`, `u`.`profile_image` AS `u_image`, `u`.`github_url` AS `u_link` FROM `snippets` p LEFT JOIN `users` u ON `p`.`owner_id` = `u`.`id` WHERE slug = :slug", ["slug" => $slug]);
		var_dump($data);
		exit;
	}
}