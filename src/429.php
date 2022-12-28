<?php

use Quiksnip\Web\Utils\Loader;

Loader::startLayout("404 | Not Found");
?>
<div class="w-screen h-screen flex flex-col items-center justify-center gap-3">
    <h1 class="hero-text text-[8rem] lg:text-[10rem] font-bold">
        429
    </h1>
    <p class="text-xs text-neutral-600 border border-neutral-600 rounded px-10 py-2">
        Slow down speedy! Too many requests.
    </p>
</div>
<?php
Loader::endLayout();
?>

