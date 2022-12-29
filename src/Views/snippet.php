<?php


namespace Quiksnip\Web\Views;

use Quiksnip\Web\Utils\Loader;
use Quiksnip\Web\Utils\Misc;

$user = \Quiksnip\Web\Services\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;


$s_data = $data["snip_data"];
$s_logs = $data["snip_logs"];
$s_comments = $data["snip_comments"];

if (!$s_data) {
	require(__DIR__ . "/../404.php");
	exit;
}

$error = $data["error"] ?? null;

$owns_snippet = $user["id"] === $s_data["owner_id"] && $s_data["owner_id"] !== 0;

$GLOBALS["slug"] = $s_data["slug"];

$title = "[" . strtoupper($s_data["lang"]) . "] - " . $s_data["title"];
$desc = "`" . strtolower($s_data["title"]) . "` code snippet by " . strtolower($s_data["u_username"]) . " on Quiksnip";

Loader::startEditorLayout($title, $desc);

/**
 * @var array $languages
 */
$allow_edit = (bool)$s_data["allow_edit"] || (!$is_guest && ($s_data["owner_id"] === ($user["id"] ?? -1)));
$url = Misc::getHost() . "/s/{$s_data["slug"]}";

$languages = $GLOBALS["languages"];
?>
<main class="w-full grid grid-cols-1 lg:grid-cols-6 gap-4 lg:gap-6">
    <section class="lg:col-span-4">
        <div>
            <a href="/explore" class="text-xs text-green-400 hover:opacity-50 transition-all">
                <i class="fas fa-arrow-left mr-1"></i>
                <span>Explore</span>
            </a>
        </div>

        <form class="flex flex-col mt-4 gap-6" method="POST">
            <p id="language" class="hidden"><?= $s_data["lang"] ?></p>
            <div class="flex items-center gap-3">
                <img src="<?= $s_data["u_image"] ?? "/assets/images/Logo.svg" ?>" alt="<?= $s_data["u_username"] ?>" class="w-10 h-10 rounded-full">
                <div class="space-y-1">
					<?php if (!empty($s_data["u_username"])) : ?>
                        <a href="<?= $s_data["u_link"] ?>" class="block text-sm font-mono text-neutral-200 hover:text-green-400">@<?= $s_data["u_username"] ?></a>
					<?php else : ?>
                        <p class="text-sm text-neutral-200">Guest</p>
					<?php endif; ?>
                    <p class="text-[10px] text-neutral-600"><?= \Quiksnip\Web\Utils\Misc::formatDateTime($s_data["created_at"]) ?></p>
                </div>
            </div>

			<?php if (isset($error)): ?>
                <div class="error" role="alert">
                    <span><?= $error ?></span>
                </div>
			<?php endif; ?>

            <div>
                <div class="window-top">
                    <div class="window-btn-container">
                        <div class="window-btn red" id="close-btn"></div>
                        <div class="window-btn yellow"></div>
                        <div class="window-btn green"></div>
                    </div>
                    <h4><?= $s_data["title"] ?></h4>
                    <button title="Copy URL" type="button" class="text-xs text-green-400 hover:opacity-50 transition-all" onclick="copyText('<?= $url ?>')">
                        <!-- <i class="fa-solid fa-copy text-sm"></i> -->
                        Copy URL
                    </button>
                </div>
                <textarea name="content" id="editor" data-readonly="<?= $allow_edit ? 'false' : 'true' ?>"><?= $s_data["content"]; ?></textarea>
                <div class="window-bottom">
                    <p class="date"><?= \Quiksnip\Web\Utils\Misc::timeAgo($s_data["created_at"]) ?></p>
                    <p class="lang"><?= ucfirst($s_data["lang"]) ?></p>
                </div>
            </div>

			<?php if (($s_data["allow_edit"] && !$is_guest) || ($owns_snippet)): ?>
                <div class="lg:flex lg:justify-end">
                    <button type="submit" name="update_snippet" class="w-full lg:w-max btn-primary">Save</button>
                </div>
			<?php endif; ?>
        </form>
    </section>

	<?php if ($owns_snippet) : ?>
        <section class="lg:col-span-2 space-y-6">
			<?php require __DIR__ . "/components/session_url.php" ?>

            <div class="w-full h-[35vh] overflow-hidden bg-dark rounded-lg">
                <div class="border-b border-b-neutral-800 py-3">
                    <h4 class="text-sm text-neutral-500 text-center">Events</h4>
                </div>
                <div class="h-full overflow-scroll pt-4 pb-12">
					<?php if (count($s_logs) == 0) : ?>
                        <div class="text-center text-red-500 py-10">
                            <i class="fas fa-info-circle text-2xl"></i>
                            <p class="text-xs mt-1">No events to show</p>
                        </div>
					<?php else : ?>
						<?php foreach ($s_logs as $log) : ?>
                            <div class="flex flex-col mb-4 px-3">
                                <p class="text-xs"><span class="bg-green-400 text-[10px] text-neutral-900 rounded px-2 py-1 mr-2"><?= $log["event"] ?></span><?= $log["created_at"] ?></p>
                            </div>
						<?php endforeach; ?>
					<?php endif; ?>
                </div>
            </div>
        </section>
	<?php endif; ?>

    <section>
        <h1 class="text-xl lg:text-2xl text-neutral-700 font-semibold px-1 mb-4">Comments</h1>
    </section>
</main>


<?php
Loader::endEditorLayout();
?>
