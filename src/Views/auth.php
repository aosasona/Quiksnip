<?php

use Quiksnip\Quiksnip\Utils\Loader;

if (isset($_SESSION["user"])) {
	header("Location: /explore");
	exit;
}

$error = $data["error"] ?? null;

Loader::startLayout("Authentication");
?>

<main class="container h-[80vh] flex items-center justify-center mx-auto">

    <div class="w-full md:w-3/5 lg:w-2/5 2xl:w-2/6 border border-neutral-800 px-5 py-6 rounded-lg">
		<?php if (isset($error)): ?>
            <div class="text-xs bg-red-500 bg-opacity-20 text-red-600 px-4 py-3 rounded relative mb-4"
                 role="alert">
                <span class=""><?= $error ?></span>
            </div>
		<?php endif; ?>

        <form method="post" action="/auth">
            <button name="github_login"
                    class="w-full flex items-center justify-center gap-2 bg-white hover:-translate-y-1 text-neutral-900 text-xs lg:text-sm font-medium py-3 px-4 rounded transition-all">
                <i class="block fa-brands fa-github text-base lg:text-lg"></i>
                <span>Continue with GitHub</span>
            </button>
        </form>

        <div class="flex items-center justify-center my-3">
            <div class="w-1/5 border-b border-neutral-800"></div>
            <div class="mx-2 text-neutral-400 text-xs font-medium">
                OR
            </div>
            <div class="w-1/5 border-b border-neutral-800"></div>
        </div>

        <a href="/explore"
           class="w-full flex items-center justify-center gap-2 bg-neutral-900 hover:-translate-y-1 text-white text-xs lg:text-sm font-medium py-3 px-4 rounded transition-all">
            Continue
            as
            guest
        </a>
    </div>
</main>

<?php
Loader::endLayout();
?>
