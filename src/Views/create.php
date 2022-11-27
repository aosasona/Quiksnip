<?php

use Quiksnip\Web\Utils\Loader;

Loader::startEditorLayout("Create Snippet");

$languages = $GLOBALS["languages"];
$is_guest = $GLOBALS["is_guest"];
$user = $GLOBALS["user"];

?>
<section class="w-full lg:w-4/5 mx-auto">
    <div>
        <a href="/explore" class="text-xs text-green-400 hover:opacity-50 transition-all">
            <i class="fas fa-arrow-left mr-1"></i>
            <span>Explore</span>
        </a>
    </div>
    <form class="flex flex-col mt-4 gap-6" action="/new" method="POST">
		<?php if (isset($_SESSION["error"])): ?>
            <div class="error" role="alert">
                <span><?= $_SESSION["error"] ?></span>
            </div>
		<?php endif; ?>

        <div>
            <div class="window-top">
                <input type="text" name="title" id="title" title="Snippet's description" placeholder="convert csv file to json" minlength="10" maxlength="75" required/>
                <select name="lang" id="language" title="Snippet's language" class="w-full" required>
					<?php
					foreach ($languages as $key => $value) {
						$selected = $key === "javascript" ? "selected" : "";
						$name = $value["name"];
						echo "<option value=\"{$key}\" {$selected}>{$name}</option>";
					}
					?>
                </select>
                <div>
                    <input type="checkbox" name="is_private" id="is_private" class="hidden" value="1"/>
                    <label for="is_private" class="check-label p-0" title="Mark snippet as private"><i class="fa-solid fa-lock"></i></label>
                </div>
            </div>

            <div>
                <textarea name="content" id="editor"></textarea>
            </div>

            <div class="window-bottom">
				<?php if (!$is_guest): ?>
                    <div class="grid grid-cols-2 items-center gap-4">
                        <div>
                            <input type="checkbox" name="allow_comments" id="allow_comments" class="hidden" value="1"/>
                            <label for="allow_comments" class="check-label" title="Allow comments and engagements">
                                <i class="fa-solid fa-comment"></i>
                            </label>
                        </div>
                        <div>
                            <input type="checkbox" name="allow_edits" id="allow_edits" class="hidden" value="1"/>
                            <label for="allow_edits" class="check-label" title="Allow snippet to be publicly edited">
                                <i class="fa-solid fa-edit"></i>
                            </label>
                        </div>
                    </div>
				<?php endif; ?>
                <div class="">
                    <button type="submit" class="w-full lg:w-max btn-primary">Save</button>
                </div>
            </div>
        </div>

        <div class="w-full mt-2">
            <div class="mb-3 px-1">
                <h2 class="text-green-400 font-semibold text-2xl">Access</h2>
                <h5 class="text-neutral-600 text-xs">Who can view this snippet?</h5>
            </div>
            <textarea name="whitelist" id="whitelist" placeholder="eg. genx, genx@gitarena.com" rows="8"></textarea>
        </div>
    </form>
</section>

<?php
Loader::endEditorLayout();
?>
