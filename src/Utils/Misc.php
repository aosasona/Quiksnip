<?php

namespace Quiksnip\Web\Utils;

use Exception;


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


	/**
	 * @throws Exception
	 */
	public static function timeAgo(string $date): string
	{
		$dt = new \DateTime($date);
		$dt = $dt->getTimestamp();
		$now = time();
		$diff = $now - $dt;
		$diff = round($diff / 60);
		$diff = round($diff / 1440);
		if ($diff <= 1) {
			return "Just now";
		} else {
			$noun = ($diff > 1 ? "days" : "day") . " ago";
			return "Created " . $diff . " " . $noun;
		}
	}


	public static function generateTimestampMilliseconds(): float
	{
		return round(microtime(true) * 1000);
	}


	public static function rotateLog(string $file = "error.txt"): void
	{
		$dt = new \DateTime();
		$dt = $dt->format("d M Y, H:i");
		$message = "[$dt] Rotating log file\n";
		file_put_contents($file, $message, FILE_APPEND);
		rename($file, "error-$dt.txt");
	}


	public static function logError(string $message, string $file = "error.log"): void
	{
		$log_file = __DIR__ . "/../../logs/$file";
		$dt = new \DateTime();
		$dt = $dt->format("d M Y, H:i");
		$message = "[$dt] $message\n";
		file_put_contents($log_file, $message, FILE_APPEND);
		if (filesize($log_file) > 1000000) {
			self::rotateLog($log_file);
		}
	}
}
