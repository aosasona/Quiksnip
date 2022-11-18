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
<main class="container w-full flex flex-col lg:flex-row-reverse gap-6 mx-auto mt-[12.5vh] lg:mt-[14vh]">
    <section class="w-full lg:max-w-3xl mx-auto">
		<?php include_once __DIR__ . "/components/explore_snippets.php"; ?>
    </section>
</main>

<?php
Loader::endLayout();
?>
