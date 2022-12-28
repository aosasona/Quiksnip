<?php

namespace Quiksnip\Web\Services;

use Quiksnip\Web\Models\Session as SessionModel;
use Quiksnip\Web\Utils\Misc;

class Session
{

	public static function validateSession(string $session_key): bool
	{
		$session = new SessionModel();
		$res = $session->selectOne("SELECT (TIMESTAMPDIFF(second, created_at, now()) < ttl) AS is_valid FROM sessions WHERE session_key = ? LIMIT 1", [$session_key]);
		return (bool)$res["is_valid"];
	}


	public static function createSession(int $sid, int $ttl = 720, array $data = []): string
	{
		$key = Auth::generateSessionKey();
		$session = new SessionModel();
		$session->session_key = $key;
		$session->snippet_id = $sid;
		$session->ttl = $ttl;
		$session->data = json_encode($data);
		$session->save();
		return $key;
	}


	/*
	 * @return array<string,mixed>
	 */
	public static function decodeSession(string $key): array | null
	{
		$session = new SessionModel();
		$session_data = $session->selectOne("SELECT * FROM sessions WHERE session_key = ?", [$key]);
		if (!$session_data) return null;

		return [
			"snippet_id" => $session_data["snippet_id"],
			"key" => $session_data["session_key"],
			"data" => json_decode($session_data["data"]),
			"ttl" => $session_data["ttl"]
		];
	}


	public static function generateSessionURL(string $slug, string $key): string
	{
		return Misc::getHost() . "/s/{$slug}?_key={$key}";
	}
}
