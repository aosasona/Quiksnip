<?php

namespace Quiksnip\Web\Views;

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;


$user = \Quiksnip\Web\Services\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$stats = SnippetsController::collectStats($user["email"]);
}

$page = $_GET["page"] ?? 1;
$q_username = $_GET["user"] ?? null;
$q_lang = $_GET["lang"] ?? null;
$q_search = $_GET["q"] ?? null;
$data = SnippetsController::getSnippets($page, $q_lang, $q_username, $q_search);
$snippets = $data["snippets"];
$page_title = "explore";

Loader::startLayout("Explore");
?>
<section class="container w-full lg:max-w-3xl mx-auto mt-[12.5vh] lg:mt-[14vh]">
	<div class="mb-12">
		<?php include_once __DIR__ . "/components/explore_snippets.php"; ?>
	</div>
</section>

<?php
Loader::endLayout();
?>
