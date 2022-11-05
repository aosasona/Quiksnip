<?php

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$stats = SnippetsController::collectStats($user["email"]);
}

$snippets = SnippetsController::getSnippets();

Loader::startLayout("Create Snippet");
?>
<main class="container w-full flex flex-col-reverse lg:flex-row gap-6 mx-auto mt-[11vh] lg:mt-[14vh]">
    <section class="w-full lg:w-[65%] lg:h-[80vh]">
    </section>

    <section class="block w-full lg:w-[30%] h-auto self-start" x-data="{ open: true }">
    </section>
</main>
<?php
Loader::endLayout();
?>
