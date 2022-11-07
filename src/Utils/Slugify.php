<?php

namespace Quiksnip\Web\Utils;

class Slugify
{
	public static function create(string $str): string
	{
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		return preg_replace('/-+/', "-", $str);
	}
}
