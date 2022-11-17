<?php

namespace Quiksnip\Web\Controllers;

use Quiksnip\Web\Exceptions\HTTPException;
use Quiksnip\Web\Models\Snippet;
use Quiksnip\Web\Utils\Slugify;
use Quiksnip\Web\Utils\Validator;
use Trulyao\PhpRouter\HTTP\Request;
use Trulyao\PhpRouter\HTTP\Response;

class SnippetsController
{
	public function __construct()
	{
	}


	private static function getOwnerId(): int
	{
		return $_SESSION["user"]["id"];
	}


	public static function createSnippet(Request $req, Response $res): void
	{
		try {
			unset($_SESSION["error"], $_SESSION["temp_snippet"]);

			Validator::checkNullFields($req->body(), ["title", "lang", "content"]);

			$snippet = new Snippet();
			$snippet->title = $req->body("title");
			$snippet->lang = $req->body("lang");
			$snippet->slug = Slugify::create($req->body("title"));
			$snippet->content = $req->body("content");
			$snippet->is_public = (int)$req->body("is_public");;
			$snippet->allow_comments = (int)$req->body("allow_comments");;
			$snippet->allow_edit = (int)$req->body("allow_edit");;
			$snippet->up_votes = 0;
			$snippet->down_votes = 0;
			$snippet->owner_id = self::getOwnerId();
			$snippet->save();

			$uri = "/snippets/" . $snippet->slug;
			$res->redirect($uri);
		} catch (HTTPException $e) {
			$_SESSION["temp_snippet"] = $req->body();
			$_SESSION["error"] = $e->getMessage();
			$res->redirect("/new");
		} catch (\Exception $e) {
			$_SESSION["temp_snippet"] = $req->body();
			$_SESSION["error"] = "Something went wrong. Please try again later.";
			$res->redirect("/new");
		}
	}


	public static function getSnippets(int $page = 1, int $page_size = 25): array
	{
		$snippets = new Snippet();
		$offset = ($page - 1) * $page_size;
		$snippets_count = $snippets->count();
		if ($offset > $snippets_count) {
			$offset = 0;
		}

		if ($snippets_count > 0) {
			$data = $snippets->selectMany("SELECT * FROM `snippets` ORDER BY `created_at` DESC LIMIT {$page_size} OFFSET {$offset}");
		} else {
			$data = [];
		}
		return $data;
	}


	public static function collectStats(string $email): ?array
	{
		try {
			$stats = [
				"snippets" => 0,
				"up_votes" => 0,
				"down_votes" => 0,
			];

			$snippets = new Snippet();
			$owner_id = self::getOwnerId();

			$stats["snippets"] = (int)$snippets->selectOne("SELECT COUNT(*) AS `count` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])["count"];

			$stats["up_votes"] = (int)$snippets->selectOne("SELECT SUM(`up_votes`) as `up_votes` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])["up_votes"];

			$stats["down_votes"] = (int)$snippets->selectOne("SELECT SUM(`down_votes`) as `down_votes` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])["down_votes"];

			return $stats;
		} catch (\Exception $e) {
			return null;
		}
	}

}