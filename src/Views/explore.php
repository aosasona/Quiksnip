<?php

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$stats = SnippetsController::collectStats($user["email"]);
}

$snippets = SnippetsController::getSnippets();

Loader::startLayout("Explore");
?>
<main class="container w-full flex flex-col lg:flex-row-reverse gap-6 mx-auto mt-[12vh] lg:mt-[14vh]">
    <section class="hidden lg:block w-full lg:w-[30%] h-auto self-start" x-data="{ open: true }">
		<?php include_once __DIR__ . "/components/profile_card.php"; ?>
    </section>


    <section class="w-full lg:w-[65%] lg:h-[80vh] lg:overflow-y-scroll">
		<?php include_once __DIR__ . "/components/explore_snippets.php"; ?>
    </section>
</main>

<?php
Loader::endLayout();
?>
