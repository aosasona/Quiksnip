<?php require_once __DIR__ . "/../../Utils/constants.php" ?>
<div class="flex justify-between items-center px-1">
    <div class="flex flex-col gap-1.5">
        <h1 class="text-3xl lg:text-3xl font-semibold text-neutral-200 tracking-wide mb-2">Explore</h1>
		<?php if (!$q_lang && !$q_search && !$q_username && strtolower($q_username ?? "") !== "guest") : ?>
            <p class="text-neutral-600 text-xs font-mono tracking-wide">
                Discover latest snippets from the community
            </p>
		<?php else : ?>
            <p class="text-xs text-neutral-600 font-mono tracking-wide">
                Showing matches <span><?= $q_search ? "for " . $q_search : "" ?></span> in language <span class="text-green-400"><?= $q_lang ?? "all" ?></span> by <span class="text-green-400"><?= $q_username ?? "all" ?></span>
            </p>
		<?php endif; ?>
    </div>
    <a href="/new"
       class="fixed lg:relative bottom-6 right-6 lg:bottom-0 lg:right-0 lg:block bg-green-400 text-[10px] text-neutral-900 font-medium hover:-translate-y-2 cursor-pointer rounded-md lg:rounded p-5 lg:p-0 lg:py-1.5 lg:px-3 my-0 transition-all">
        <i class="fa-solid fa-plus text-xl lg:text-xs"></i>
    </a>
</div>

<form action="/explore" method="GET" class="flex gap-2 mt-3">
    <input type="search" name="q" placeholder="Search"/>
    <button type="submit" class="bg-green-400 hover:bg-green-600 text-neutral-900 px-5 rounded-lg">
        <i class="fa-solid fa-search"></i>
    </button>
</form>


<?php
/** @var $snippets
 * @var $languages
 */
if (count($snippets) > 0) : ?>
    <div class="grid grid-cols-1 gap-3 mt-5">
		<?php foreach ($snippets as $snippet) : ?>
            <div class="snippet-card">
                <a href="/s/<?= $snippet['slug'] ?>" class="title">
					<?= ucfirst($snippet['title']) ?>
                </a>
                <div class="flex justify-between items-center">
                    <div class="snippet-ratings">
                        <p>
                            <i class="fa-solid fa-circle-up"></i> <span><?= $snippet['up_votes'] ?></span>
                        </p>
                        <p>
                            <i class="fa-solid fa-circle-down"></i> <span><?= $snippet['down_votes'] ?></span>
                        </p>
                    </div>
                    <a class="outline-none hover:no-underline" href="?lang=<?= $snippet["lang"] ?>">
                        <p class="w-max text-[8px] lg:text-[10px] font-medium bg-opacity-80 rounded px-1.5 py-1" style="background-color: <?= $languages[strtolower($snippet["lang"])]["bg"] ?>;
                                color: <?= $languages[strtolower($snippet["lang"])]["text"] ?>">
                            <span class="tracking-wider uppercase"><?= $snippet['lang'] ?></span>
                        </p>
                    </a>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="flex flex-col items-center justify-center h-[35vh] border border-neutral-900 mt-5 rounded">
        <h2 class="text-sm lg:text-xl font-medium text-red-400">No snippets... 🥲</h2>
    </div>
<?php endif; ?>
