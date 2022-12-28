<?php

namespace Quiksnip\Web\Utils;

use Quiksnip\Web\Models\Logs;
use Quiksnip\Web\Models\Request;
use Quiksnip\Web\Services\Auth;


class Logger
{

	public const SHARED = "shared";
	public const CREATED = "created";
	public const VIEWED = "viewed";
	public const GENERATED_SESSION_URL = "generated session url";


	public static function logEvent(int $sid, string $event, string $data, string $subject = "web"): void
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


	public static function logRequest(string $ip_address): void
	{
		$request = new Request();
		$request->ip_address = $ip_address;
		$request->path = $_SERVER["REQUEST_URI"];
		$request->_get = json_encode($_GET);
		$request->_post = json_encode($_POST);
		$request->save();
	}
}
