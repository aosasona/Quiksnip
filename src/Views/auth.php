<?php

use Quiksnip\Quiksnip\Utils\Loader;

Loader::startLayout("Authentication");
?>

<main class="container h-[80vh] flex items-center justify-center mx-auto">
    <div class="w-full md:w-3/5 lg:w-2/5 2xl:w-2/6 border border-neutral-800 px-5 py-6 rounded-lg">
        <button class="w-full flex items-center justify-center gap-2 bg-white hover:-translate-y-1 text-neutral-900 text-xs lg:text-sm font-medium py-3 px-4 rounded transition-all">
            <i class="block fa-brands fa-github text-base lg:text-lg"></i>
            Continue with GitHub
        </button>

        <div class="flex items-center justify-center my-3">
            <div class="w-1/5 border-b border-neutral-800"></div>
            <div class="mx-2 text-neutral-400 text-xs font-medium">OR</div>
            <div class="w-1/5 border-b border-neutral-800"></div>
        </div>

        <a href="/app" class="w-full flex items-center justify-center gap-2 bg-neutral-900 hover:-translate-y-1 text-white text-xs lg:text-sm font-medium py-3 px-4 rounded transition-all">
            Continue as guest
        </a>
    </div>
</main>

<?php
Loader::endLayout();
?>
