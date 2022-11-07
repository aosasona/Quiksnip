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
		$data = $snippet->select("SELECT `p`.* FROM `snippets` AS p WHERE slug = :slug", ["slug" => $slug]);
		var_dump($data);
		exit;
	}
}