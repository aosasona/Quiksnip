<?php

namespace Quiksnip\Web\Controllers;

use Quiksnip\Web\Exceptions\HTTPException;
use Quiksnip\Web\Models\Snippet;
use Quiksnip\Web\Models\User;
use Quiksnip\Web\Services\Auth;
use Quiksnip\Web\Utils\Logger;
use Quiksnip\Web\Utils\Misc;
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
			$is_guest = Auth::isGuest();

			Validator::checkNullFields($req->body(), ["title", "lang", "content"]);
			Validator::validateMinLength($req->body()["title"], "Title", 4);
			Validator::validateMinLength($req->body()["content"], "Snippet code", 10);

			$snippet = new Snippet();
			$snippet->title = $req->body("title");
			$snippet->lang = $req->body("lang");
			$snippet->slug = Slugify::create($req->body("title"));
			$snippet->content = $req->body("content");
			$snippet->is_public = $is_guest ? 1 : (int)$req->body("is_public");;
			$snippet->allow_comments = $is_guest ? 1 : (int)$req->body("allow_comments");;
			$snippet->allow_edit = $is_guest ? 0 : (int)$req->body("allow_edit");;
			$snippet->up_votes = 0;
			$snippet->down_votes = 0;
			$snippet->owner_id = self::getOwnerId();
			$snippet->save();

			$snippet->id = $snippet->getLastInsertId();

			$data = json_encode([
				"id" => $snippet->id,
				"slug" => $snippet->slug,
				"logged_in" => (bool)$_SESSION["user"]["id"],
				"created_at" => Misc::formatDateTime(),
			]);

			Logger::logEvent($snippet->id, Logger::CREATED, $data);

			$uri = "/s/" . $snippet->slug;
			$res->redirect($uri);
		} catch (HTTPException $e) {
			$_SESSION["temp_snippet"] = $req->body() + [
					"temp_time" => Misc::generateTimestampMilliseconds(),
					"error" => $e->getMessage(),
				];
			$res->redirect("/new");
		} catch (\Exception $e) {
			$_SESSION["temp_snippet"] = $req->body() + [
					"temp_time" => Misc::generateTimestampMilliseconds(),
					"error" => "Something went wrong. Please try again later.",
				];
			$res->redirect("/new");
		}
	}


	/**
	 */
	public static function updateContent(int $id, string $content): string | null
	{
		try {

			$is_guest = Auth::isGuest();
			$user_id = self::getOwnerId();
			$post_data = $_POST;

			Validator::checkNullFields($post_data, ["content"]);
			Validator::validateMinLength($post_data["content"], "Snippet code", 10);

			if ($is_guest) {
				throw new HTTPException("You are not allowed to edit this snippet.", 403);
			}

			$old_snippet = (new Snippet())->findOne($id);
			if (!$old_snippet) throw new HTTPException("Snippet not found.", 404);
			if (!$old_snippet["allow_edit"] && $user_id !== $old_snippet["owner_id"]) throw new HTTPException("You are not allowed to edit this snippet.", 403);

			$snippet = new Snippet();
			$snippet->id = $id;
			$snippet->content = $post_data["content"];
			$snippet->update();

			$data = json_encode([
				"id" => $snippet->id,
				"slug" => $old_snippet["slug"],
				"is_invited" => (bool)isset($_SESSION["_key"]),
				"previous_content" => $old_snippet["content"],
				"created_at" => Misc::formatDateTime(),
			]);

			Logger::logEvent($snippet->id, Logger::EDITED, $data);

			return null;
		} catch (HTTPException $e) {
			return $e->getMessage();
		} catch (\Exception $e) {
			return "Something went wrong. Please try again later.";
		}
	}


	public static function deleteSnippet(string $slug): ?string
	{
		try {
			$snippet = new Snippet();
			$snippet->id = $snippet->selectOne("SELECT `id` FROM `snippets` WHERE `slug` = ?", [$slug])["id"];
			if (!$snippet->id) throw new HTTPException("Snippet not found.", 404);
			$snippet->delete();
			return null;
		} catch (\Exception $e) {
			return "Something went wrong. Please try again later.";
		}
	}


	/*
 	 * @return array
 	 */
	public static function getSnippets(int $page = 1, string | null $lang = null, string | null $user = null, string | null $search_query = null): array
	{
		$snippets = new Snippet();
		$page_size = 50;
		$offset = ($page - 1) * $page_size;
		$snippets_count = $snippets->count();
		if ($offset > $snippets_count) {
			$offset = 0;
		}

		$replacement_array = [];
		$where_statement = "WHERE `is_public` = 1";

		if ($lang) {
			$where_statement .= " AND lang = :lang";
			$replacement_array["lang"] = $lang;
		}

		if ($user) {
			$where_statement .= " AND owner_id = :user";
			$user_search = (new User())->selectOne("SELECT `id` FROM users WHERE username = :user LIMIT 1", ["user" => $user]);
			$replacement_array["user"] = $user_search["id"] ?? -1;
		}

		if ($search_query) {
			$where_statement .= " AND title LIKE :search_query";
			$replacement_array["search_query"] = "%$search_query%";
		}

		return self::fetchSnippetsData($snippets_count, $snippets, $where_statement, $page_size, $offset, $replacement_array, $page);
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


	public static function getUserSnippets(int $user_id, int $page = 1, string | null $lang = null): array
	{
		$snippets = new Snippet();
		$page_size = 25;
		$offset = ($page - 1) * $page_size;
		$snippets_count = $snippets->count();
		if ($offset > $snippets_count) {
			$offset = 0;
		}

		$replacement_array = [];
		$where_statement = "WHERE `owner_id` = :user_id";
		$replacement_array["user_id"] = $user_id;

		if ($lang) {
			$where_statement .= " AND lang = :lang";
			$replacement_array["lang"] = $lang;
		}

		return self::fetchSnippetsData($snippets_count, $snippets, $where_statement, $page_size, $offset, $replacement_array, $page);
	}


	/**
	 * @param  int        $snippets_count
	 * @param  Snippet    $snippets
	 * @param  string     $where_statement
	 * @param  int        $page_size
	 * @param  float|int  $offset
	 * @param  array      $replacement_array
	 * @param  int        $page
	 *
	 * @return array
	 */
	public static function fetchSnippetsData(int $snippets_count, Snippet $snippets, string $where_statement, int $page_size, float | int $offset, array $replacement_array, int $page): array
	{
		if ($snippets_count > 0) {
			$data = $snippets->selectMany("SELECT * FROM `snippets` ${where_statement} ORDER BY `created_at` DESC LIMIT {$page_size} OFFSET {$offset}", $replacement_array);
			$total_pages = ceil($snippets_count / $page_size);
			$data = [
				"snippets" => $data,
				"total_pages" => $total_pages,
				"current_page" => $page,
			];
		} else {
			$data = [];
		}
		return $data;
	}
}
