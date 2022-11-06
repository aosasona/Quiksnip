<?php

namespace Quiksnip\Web\Utils;

class Loader
{
	public static function startLayout($title): void
	{
		$dir = dirname(__DIR__, 2);
		require_once($dir . "/src/Views/layouts/top.php");
	}


	public static function endLayout(): void
	{
		$dir = dirname(__DIR__, 2);
		require_once($dir . "/src/Views/layouts/bottom.php");
	}


	public static function startEditorLayout($title): void
	{
		$dir = dirname(__DIR__, 2);
		require_once($dir . "/src/Views/layouts/top-editor.php");
	}


	public static function endEditorLayout(): void
	{
		$dir = dirname(__DIR__, 2);
		require_once($dir . "/src/Views/layouts/bottom-editor.php");
	}
}