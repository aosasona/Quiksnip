<?php

namespace Quiksnip\Web\Utils;

class Slugify
{
	public static function create(string $str, bool $append_extra = true): string
	{
		$str = strtolower(trim($str));
		if ($append_extra) {
			$str .= "-" . uniqid();
		}
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		return preg_replace('/-+/', "-", $str);
	}
}
