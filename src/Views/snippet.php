<?php

use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;


$s_data = $data["snip_data"];
$s_logs = $data["snip_logs"];
$s_comments = $data["snip_comments"];

$desc = "View `" . $s_data["title"] . "` snippet by " . $s_data["u_username"] . " on Quiksnip";
Loader::startEditorLayout(strtoupper($s_data["lang"]) . " - " . $s_data["title"], $desc);

/**
 * @var array $languages
 */

$allow_edit = $s_data["allow_edit"] === 1 || $s_data["owner_id"] === $user["id"];
$url = "https://{$_SERVER["HTTP_HOST"]}/snippets/{$s_data["slug"]}";

$languages = $GLOBALS["languages"];
?>
<main class="w-full grid grid-cols-1 lg:grid-cols-6 gap-4">
    <section class="lg:col-span-4">
        <div>
            <a href="/explore" class="text-xs text-green-400 hover:opacity-50 transition-all">
                <i class="fas fa-arrow-left mr-1"></i>
                <span>Explore</span>
            </a>
        </div>
        <form class="flex flex-col mt-4 gap-6" action="/update" method="POST">
			<?php if (isset($_SESSION["error"])): ?>
                <div class="error" role="alert">
                    <span><?= $_SESSION["error"] ?></span>
                </div>
			<?php endif; ?>
            <p id="language" class="hidden"><?= $s_data["lang"] ?></p>
            <div class="flex items-center gap-3">
                <img src="<?= $s_data["u_image"] ?? "/assets/images/Logo.svg" ?>" alt="<?= $s_data["u_username"] ?>" class="w-10 h-10 rounded-full">
                <div class="space-y-1">
					<?php if (!empty($s_data["u_username"])): ?>
                        <a href="<?= $s_data["u_link"] ?>" class="block text-sm font-mono text-neutral-200 hover:text-green-400">@<?= $s_data["u_username"] ?></a>
					<?php else: ?>
                        <p class="text-sm text-neutral-200">Guest</p>
					<?php endif; ?>
                    <p class="text-[10px] text-neutral-600"><?= (new DateTime($s_data["created_at"] ?? "now"))->format("d M Y H:i") ?></p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-medium my-0"><?= ucfirst($s_data["title"]) ?></h1>
                <div class="flex items-center">
                    <button title="Copy URL" type="button" class="text-xs text-green-400 hover:opacity-50 transition-all" onclick="copyText('<?= $url ?>')">
                        <i class="fa-solid fa-copy text-lg"></i>
                    </button>
                </div>
            </div>

            <div>
                <textarea name="content" id="editor" data-readonly="<?= $allow_edit ? 'true' : 'false' ?>"><?= $s_data["content"]; ?></textarea>
            </div>

            <div class="lg:flex lg:justify-end">
                <button type="submit" class="w-full lg:w-max btn-primary disabled:hidden" disabled>Create Snippet</button>
            </div>
        </form>
    </section>

    <section class="lg:col-span-2"></section>
</main>


<?php
Loader::endEditorLayout();
?>
