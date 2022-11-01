<?php

use Quiksnip\Quiksnip\Utils\Loader;

Loader::startLayout("Quiksnip");
?>
<div class="w-screen h-screen flex flex-col items-center justify-center">
    <h1 class="hero-text text-[8rem] font-bold">
        404
    </h1>
    <p class="text-xs text-neutral-600 border border-neutral-600 rounded px-6 py-2">Page not found!</p>
</div>
<?php
Loader::endLayout();
?>

