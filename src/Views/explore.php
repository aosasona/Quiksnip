<?php

use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;

if (!$is_guest) {
	$stats = SnippetsController::collectStats($user["email"]);
}

$page = $_GET["page"] ?? 1;
$data = SnippetsController::getSnippets($page);
$snippets = $data["snippets"];
$total_pages = $data["total_pages"];
$current_page = $data["current_page"];

Loader::startLayout("Explore");
?>
<main class="container w-full lg:max-w-3xl mx-auto mt-[12.5vh] lg:mt-[14vh]">
    <section class="mb-12">
		<?php include_once __DIR__ . "/components/explore_snippets.php"; ?>
    </section>
	<?php if ($total_pages > 1): ?>
        <div class="w-full grid grid-cols-3 text-center justify-center mx-auto">
            <div class="self-center text-left">
				<?php if ($current_page > 1):
					$prev_page = $current_page - 1;
					?>
                    <a href="/explore?page=<?= $prev_page ?>" class="text-xs text-green-400 hover:opacity-50 transition-all px-3 py-1">
                        <i class="fas fa-arrow-left mr-1"></i><span>Previous</span>
                    </a>
				<?php endif; ?>
            </div>
            <div class="w-max bg-neutral-900 text-neutral-300 text-xs flex gap-2 justify-center items-center mx-auto rounded px-3 py-1">
                <span>Page</span>
                <span><?= $current_page ?></span>
                <span>of</span>
                <span><?= $total_pages ?></span>
            </div>
            <div class="self-center text-right">
				<?php if ($current_page < $total_pages): ?>
                    <a href="/explore?page=<?= $current_page + 1 ?>" class="text-xs text-green-400 hover:opacity-50 transition-all px-3 py-1">
                        <span>Next</span><i class="fas fa-arrow-right ml-1"></i>
                    </a>
				<?php endif; ?>
            </div>
        </div>
	<?php endif; ?>
</main>

<?php
Loader::endLayout();
?>
