<?php

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Services\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$stats = SnippetsController::collectStats($user["email"]);
}

Loader::startLayout("Explore");
?>
<main class="container w-full flex flex-col lg:flex-row-reverse gap-6 mx-auto mt-[12vh] lg:mt-[14vh]">
    <section class="w-full lg:w-[30%] h-auto self-start">
		<?php include_once __DIR__ . "/components/profile_card.php"; ?>
    </section>
    <section class="w-full lg:w-[65%] h-auto self-start" x-data="{ tab: 1 }">
        <div class="w-full flex items-center gap-3 border-b border-b-neutral-800 py-2">
            <button :class="tab === 1 && 'bg-green-400 text-neutral-900 font-medium'" class="tab-button" @click="tab = 1">
                About Me
            </button>
            <button :class="tab === 2 && 'bg-green-400 text-neutral-900 font-medium'" class="tab-button" @click="tab = 2">
                My Snippets
            </button>
        </div>
        <div class="text-center text-xs text-neutral-500 font-mono py-28" x-show="tab === 1" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <p>You'll be able to edit your profile soon!</p>
        </div>
        <div class="text-center text-xs text-neutral-500 font-mono py-28" x-show="tab === 2" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <p>You'll be able to see your snippets here soon!</p>
        </div>
    </section>
</main>
<?php
Loader::endLayout();
?>
