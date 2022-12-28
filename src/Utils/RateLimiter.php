<?php

namespace Quiksnip\Web\Utils;

use JetBrains\PhpStorm\NoReturn;

class RateLimiter
{
	public static function checkRateLimit(string $ip_address, int $ttl = 5, int $max_requests = 5): bool
	{
		$request = new \Quiksnip\Web\Models\Request();
		$requests = $request->selectMany("SELECT * FROM requests WHERE ip_address = ? AND path IS NOT NULL AND created_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)", [$ip_address, $ttl]);
		return count($requests) <= $max_requests;
	}


	#[NoReturn] public static function throwRateLimitError(): void
	{
		http_response_code(429);
		require __DIR__ . "/../429.php";
		exit;
	}


	public static function checkRateLimitAndThrow(string $ip_address, int $ttl = 5, int $max_requests = 5): void
	{
		if ($_SERVER["REQUEST_METHOD"] === "GET") $max_requests = $max_requests * 1.5;
		if (!self::checkRateLimit($ip_address, $ttl, $max_requests)) {
			self::throwRateLimitError();
		}
		Logger::logRequest($ip_address);
	}
}