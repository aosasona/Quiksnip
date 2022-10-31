<?php

namespace Quiksnip\Quiksnip\Utils;

class Loader
{
    public static function startLayout($title): void
    {
        $dir = dirname(__DIR__, 2);
        require_once($dir ."/src/Views/inc/top.php");
    }

    public static function endLayout(): void
    {
        $dir = dirname(__DIR__, 2);
        require_once($dir ."/src/Views/inc/bottom.php");
    }
}