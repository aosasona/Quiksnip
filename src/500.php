<?php

use Quiksnip\Web\Utils\Loader;

Loader::startLayout("500 | Internal Server Error");
?>
<div class="w-screen h-screen flex flex-col items-center justify-center gap-3">
    <h1 class="hero-text text-[8rem] lg:text-[10rem] font-bold">
        500
    </h1>
    <p class="text-xs text-neutral-600 border border-neutral-600 rounded px-10 py-2">
        Something went wrong, please try again later!
    </p>
    <a href="/"
       class="text-xs text-green-400 mt-5">
        <i class="fa-solid fa-arrow-left mr-1"></i> <span>Go back</span>
    </a>
</div>
<?php
Loader::endLayout();
?>

