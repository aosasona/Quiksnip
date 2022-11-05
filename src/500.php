<?php

use Quiksnip\Web\Utils\Loader;

Loader::startLayout("Quiksnip");
?>
<div class="w-screen h-screen flex flex-col items-center justify-center gap-3">
    <h1 class="hero-text text-[8rem] font-bold">
        500
    </h1>
    <p class="text-xs text-neutral-600 border border-neutral-600 rounded px-6 py-2">
        Something went wrong
    </p>
    <a href="/"
       class="text-xs text-green-400 mt-5">
        <i class="fa-solid fa-arrow-left mr-1"></i> <span>Go back to home</span>
    </a>
</div>
<?php
Loader::endLayout();
?>

