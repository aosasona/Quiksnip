<?php


namespace Quiksnip\Web\Views;

use Quiksnip\Web\Utils\Misc;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;


$s_data = $data["snip_data"];
$s_logs = $data["snip_logs"];
$s_comments = $data["snip_comments"];

if (!$s_data) {
	require(__DIR__ . "/../404.php");
	exit;
}

$GLOBALS["slug"] = $s_data["slug"];

$title = "[" . strtoupper($s_data["lang"]) . "] - " . $s_data["title"];
$desc = "`" . strtolower($s_data["title"]) . "` code snippet by " . strtolower($s_data["u_username"]) . " on Quiksnip";
Loader::startEditorLayout($title, $desc);

/**
 * @var array $languages
 */
$allow_edit = (bool)$s_data["allow_edit"] || (!$is_guest && ($s_data["owner_id"] === ($user["id"] ?? -1)));
$url = 	Misc::getHost() . "/s/{$s_data["slug"]}";

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
		<form class="flex flex-col mt-4 gap-6" action="/" method="POST">
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
				<textarea name="content" id="editor" data-readonly="<?= $allow_edit ? 'true' : 'false' ?>"><?= $s_data["content"]; ?></textarea>
				<div class="window-bottom">
					<p class="date"><?= \Quiksnip\Web\Utils\Misc::timeAgo($s_data["created_at"]) ?></p>
					<p class="lang"><?= ucfirst($s_data["lang"]) ?></p>
				</div>
			</div>

			<div class="lg:flex lg:justify-end">
				<button type="submit" class="w-full lg:w-max btn-primary disabled:hidden" disabled>Create Snippet</button>
			</div>
		</form>
	</section>

	<section class="lg:col-span-2">
		<?php if ($user["id"] === $s_data["owner_id"] && $s_data["owner_id"] !== 0) : ?>
			<form method="POST">
				<div class="flex flex-col gap-2">
					<h3 class="text-lg font-bold m-0 p-0">One-time URL</h3>
					<p class="text-xs text-neutral-600 m-0 p-0">You can share this link with anyone to provide them full access to your snip for 12 hours.</p>
					<div class="w-full h-max whitespace-nowrap relative">
						<div class="w-full bg-neutral-900 text-neutral-500 text-center text-xs text-ellipsis whitespace-nowrap overflow-hidden rounded-lg px-4 py-4">
							<?= $data["session_url"] ?? "No session URL"  ?>
						</div>
						<button type="button" class="absolute h-full aspect-square top-0 right-0 bg-neutral-900 hover:bg-green-400 hover:text-neutral-900 border border-neutral-800 rounded-r-lg p-2.5 transition-all" onclick="copyText('<?= $data["session_url"] ?? "" ?>')"><i class="fa fa-copy"></i></button>
					</div>
					<button name="create_session" type="submit" class="btn-primary mt-2">Generate new link</button>
				</div>
			</form>
		<?php endif; ?>
	</section>
</main>


<?php
Loader::endEditorLayout();
?>
