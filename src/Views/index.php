<?php

use Quiksnip\Quiksnip\Utils\Loader;

Loader::startLayout("Quiksnip");
?>

<div class="container flex flex-col gap-8 lg:gap-10 lg:h-screen lg:w-screen items-center lg:justify-center mx-auto mt-[15vh] lg:mt-0">
    <h1 class="hero-text w-[85%] lg:w-4/5 2xl:w-3/5 text-4xl lg:text-7xl font-bold text-center">
        Share, edit, and collaborate on code snippets.
    </h1>

    <a href="/auth"
       class="bg-white font-medium text-xs lg:text-sm text-black px-10 py-3 lg:py-4 rounded hover:opacity-90 hover:-translate-y-2 transition-all">
        Try it out
    </a>
</div>

<?php
Loader::endLayout();
?>
