<?php

namespace Quiksnip\Web\Middleware;

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Models\Session;
use Quiksnip\Web\Models\Snippet;
use Quiksnip\Web\Services\Session as SessionService;
use Quiksnip\Web\Utils\Logger;
use Quiksnip\Web\Utils\Misc;
use Trulyao\PhpRouter\HTTP\{Request, Response};

class SnippetMiddleware
{
	public static function fetchSnippet(Request $req, Response $res,): void
	{
		$slug = $req->params("slug");
		$snippet = new Snippet();
		$snippet_data = $snippet->selectOne("SELECT `p`.*, `u`.`name` AS `u_name`, `u`.`username` AS `u_username`, `u`.`profile_image` AS `u_image`, `u`.`github_url` AS `u_link` FROM `snippets` p LEFT JOIN `users` u ON `p`.`owner_id` = `u`.`id` WHERE slug = :slug", ["slug" => $slug]);
		$snipped_log_data = $snippet->selectMany("SELECT * FROM `logs` WHERE `snippet_id` = :id ORDER BY created_at DESC", ["id" => $snippet_data["id"]]);
		$snippet_comments = $snippet->selectMany("SELECT * FROM `comments` WHERE `snippet_id` = :id ORDER BY created_at DESC", ["id" => $snippet_data["id"]]);
		$req->append("snip_data", $snippet_data);
		$req->append("snip_logs", $snipped_log_data);
		$req->append("snip_comments", $snippet_comments);
		$data = json_encode([
			"id" => $snippet_data["id"],
			"user" => $_SESSION["user"]["id"] ?? $req->query("_key") ?? "",
			"logged_in" => (bool)$_SESSION["user"]["id"],
			"created_at" => Misc::formatDateTime(),
		]);

		$session = new Session();
		$last_session = $session->selectOne("SELECT s.* FROM sessions as s WHERE snippet_id = ? AND TIMESTAMPDIFF(minute, s.created_at, now()) < s.ttl ORDER BY created_at DESC LIMIT 1;", [$snippet_data["id"]]);
		if (!$last_session) {
			$session_key = SessionService::createSession($snippet_data["id"]);
		} else {
			$session_key = $last_session["session_key"];
		}
		$req->append("session_url", SessionService::generateSessionURL($slug, $session_key));

		Logger::logEvent($snippet_data["id"], Logger::VIEWED, $data);
	}


	public static function handlePostEvents(Request $req, Response $res): void
	{
		$slug = $req->params("slug");
		$snippet_data = $req->data["snip_data"] ?? [];
		$id = $snippet_data["id"] ?? null;
		if (isset($_POST["create_session"])) {
			if (!$id) {
				$req->append("error", "Oops! Something is wrong with this snippet");
				return;
			}
			$session_key = SessionService::createSession($id);
			$req->append("session_url", SessionService::generateSessionURL($slug, $session_key));

			$data = json_encode([
				"id" => $id,
				"user" => $_SESSION["user"]["id"] ?? $req->query("_key") ?? "",
				"logged_in" => (bool)$_SESSION["user"]["id"],
				"created_at" => Misc::formatDateTime(),
			]);
			Logger::logEvent($id, Logger::GENERATED_SESSION_URL, $data);
		} elseif (isset($_POST["update_snippet"])) {
			$error = SnippetsController::updateContent($id, $_POST["content"]);
			if ($error) {
				$req->append("error", $error);
				return;
			}
		} elseif (isset($_POST["delete_snippet"])) {
			$confirm_text = $_POST["confirm_text"] ?? "";
			if ($confirm_text !== "DELETE") {
				$req->append("error", "Please type DELETE to confirm deletion");
				return;
			}
			$error = SnippetsController::deleteSnippet($slug);
			if ($error) {
				$req->append("error", $error);
				return;
			}
			$res->redirect("/explore");
		}
	}
}
