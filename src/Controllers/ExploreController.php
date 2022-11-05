<?php

namespace Quiksnip\Web\Controllers;

use Quiksnip\Web\Models\Snippet;

class ExploreController
{
	public function __construct()
	{
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
			$stats["snippets"] = $snippets->select("SELECT COUNT(*) AS `count` FROM `snippets` WHERE `owner_id` = (SELECT `id` FROM `users` WHERE email = ?)", [$email])[0]["count"];


			return $stats;
		} catch (\Exception $e) {
			return null;
		}
	}

}