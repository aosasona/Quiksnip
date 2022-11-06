<?php

use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;


/**
 * @var array $languages
 */

require __DIR__ . "/../Utils/constants.php";

Loader::startEditorLayout("Create Snippet");

foreach (array_keys($languages) as $lang) {
	echo "<script src=\"/assets/js/codemirror/mode/{$lang}/{$lang}.js\"></script>";
}

?>
<section class="w-full lg:w-4/5 mx-auto">
    <div>
        <a href="/explore" class="text-xs text-green-400 hover:opacity-50 transition-all">
            <i class="fas fa-arrow-left mr-1"></i>
            <span>Explore</span>
        </a>
    </div>
    <form class="flex flex-col mt-4 gap-6" action="/snippets/create" method="POST">
        <div class="grid grid-cols-1 lg:grid-cols-9 gap-5">
            <div class="lg:col-span-6">
                <label for="title">Snippet Name</label>
                <input type="text" name="title" id="title" placeholder="Title" required/>
            </div>
            <div class="lg:col-span-3">
                <label for="language">Language</label>
                <select name="language" id="language" class="w-full" required>
					<?php
					foreach ($languages as $key => $value) {
						$selected = $key === "javascript" ? "selected" : "";
						echo "<option value=\"{$key}\" {$selected}>{$value}</option>";
					}
					?>
                </select>
            </div>
        </div>
        <div>
            <div class="grid grid-cols-2 lg:grid-cols-3 items-center gap-4">
                <div>
                    <input type="checkbox" name="is_private" id="is_private" class="hidden"/>
                    <label for="is_private" class="check-label">Private Snippet</label>
                </div>
                <div>
                    <input type="checkbox" name="allow_comments" id="allow_comments" class="hidden"/>
                    <label for="allow_comments" class="check-label">Enable Comments</label>
                </div>
                <div class="col-span-2 lg:col-span-1">
                    <input type="checkbox" name="allow_edits" id="allow_edits" class="hidden"/>
                    <label for="allow_edits" class="check-label">Enable Comments</label>
                </div>
            </div>
            <p class="text-[11px] text-neutral-600 px-1 mt-2">Tap or click to toggle</p>
        </div>

        <div>
            <textarea id="editor"></textarea>
        </div>

        <div class="lg:flex lg:justify-end">
            <button type="submit" class="w-full lg:w-max btn-primary">Create Snippet</button>
        </div>
    </form>
</section>

<script src="/assets/js/form.js"></script>
<?php
Loader::endEditorLayout();
?>
