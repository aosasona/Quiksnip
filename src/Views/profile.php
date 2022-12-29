<?php

namespace Quiksnip\Web\Views;

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Services\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$page = $_GET["page"] ?? 1;
	$q_lang = $_GET["lang"] ?? null;
	$stats = SnippetsController::collectStats($user["email"]);
	$data = SnippetsController::getUserSnippets($user["id"], $page, $q_lang);
	$snippets = $data["snippets"];
}

$page_title = "profile";

require_once __DIR__ . "/../Utils/constants.php";

Loader::startLayout("Profile");
?>
<main class="container w-full flex flex-col lg:flex-row-reverse gap-6 mx-auto mt-[12vh] lg:mt-[14vh]">
    <section class="w-full lg:w-[30%] h-auto self-start">
		<?php include_once __DIR__ . "/components/profile_card.php"; ?>
    </section>
	<?php if (!$is_guest) : ?>
        <section class="w-full lg:w-[65%] h-auto self-start">
            <h1 class="text-xl lg:text-2xl text-neutral-700 font-semibold px-1 mb-4">My Snippets</h1>
            <div class="text-center text-xs text-neutral-500 font-mono">
				<?php
				/** @var $snippets
				 * @var $languages
				 */
				if (count($snippets) > 0) : ?>
                    <div class="grid grid-cols-1 gap-3 mb-6">
						<?php require __DIR__ . "/components/snippet_card.php" ?>
                    </div>
					<?php require __DIR__ . "/../Views/components/pagination.php"; ?>
				<?php else : ?>
                    <div class="flex flex-col items-center justify-center h-[35vh] border border-neutral-900 mt-5 rounded">
                        <h2 class="text-sm lg:text-xl font-medium text-red-400">No snippets... 🥲</h2>
                    </div>
				<?php endif; ?>
            </div>
        </section>
	<?php else : ?>
        <section class="w-full lg:w-[65%] h-[30vh] flex items-center justify-center">
            <p class="text-xs text-neutral-600 font-mono">You're logged in as a guest and can't make any changes.</p>
        </section>
	<?php endif; ?>
</main>
<?php
Loader::endLayout();
?>
