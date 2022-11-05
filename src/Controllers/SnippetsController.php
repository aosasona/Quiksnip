<?php

namespace Quiksnip\Web\Controllers;

use Quiksnip\Web\Models\Snippet;

class SnippetsController
{
	public function __construct()
	{
	}


	private static function getOwnerId(): int
	{
		return $_SESSION["user"]["id"];
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
			$data = $snippets->select("SELECT * FROM `snippets` ORDER BY `created_at` DESC LIMIT {$page_size} OFFSET {$offset}");
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

			$stats["snippets"] = (int)$snippets->select("SELECT COUNT(*) AS `count` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])[0]["count"];

			$stats["up_votes"] = (int)$snippets->select("SELECT SUM(`up_votes`) as `up_votes` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])[0]["up_votes"];

			$stats["down_votes"] = (int)$snippets->select("SELECT SUM(`down_votes`) as `down_votes` FROM `snippets` WHERE `owner_id` = ?", [$owner_id])[0]["down_votes"];

			return $stats;
		} catch (\Exception $e) {
			return null;
		}
	}

}