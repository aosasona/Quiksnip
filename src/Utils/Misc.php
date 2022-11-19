<?php

namespace Quiksnip\Web\Utils;

use Exception;
use Quiksnip\Web\Models\Logs;

class Misc
{
	public const SHARED = "shared";
	public const CREATED = "created";


	public static function formatDateTime(string $date = "now"): string
	{
		try {
			$dt = new \DateTime($date);
			return $dt->format("d M Y, H:i");
		} catch (Exception $e) {
		}

		return "";
	}


	public static function log(int $sid, string $event, string $data, string $subject = "web"): void
	{
		$user = Auth::getSessionUser() ?? null;
		if (!$user) return;
		$log = new Logs();
		$log->event = $event;
		$log->subject = $subject;
		$log->data = $data;
		$log->user_id = $user["id"] ?? 0;
		$log->snippet_id = $sid;
		$log->save();
	}
}
