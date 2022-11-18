<?php require_once __DIR__ . "/../../Utils/constants.php" ?>
    <div>
        <div class="flex justify-between items-center">
            <h1 class="text-3xl lg:text-3xl font-medium text-neutral-200 tracking-wide">Explore</h1>
            <a href="/new" class="block bg-green-400 text-[10px] lg:text-xs text-neutral-900 font-medium hover:-translate-y-2 cursor-pointer rounded px-4 py-2 lg:px-3 transition-all">
                <i class="fa-solid fa-plus"></i> <span class="ml-1">New</span>
            </a>
        </div>
        <p class="text-neutral-700 text-xs tracking-wide mt-2">
            Discover latest snippets from the community
        </p>
    </div>


<?php if (count($snippets) > 0): ?>
    <div class="grid grid-cols-1 gap-3 mt-5">
		<?php foreach ($snippets as $snippet): ?>
            <div class="snippet-card">
                <a href="/snippets/<?= $snippet['slug'] ?>">
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
                    <p class="w-max text-[8px] lg:text-[10px] font-medium bg-opacity-80 rounded px-1.5 py-1"
                       style="background-color: <?= $languages[strtolower($snippet['lang'])]["bg"] ?>;
                               color: <?= $languages[strtolower($snippet['lang'])]["text"] ?>"
                    >
                        <span class="tracking-wider capitalize"><?= $snippet['lang'] ?></span>
                    </p>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="flex flex-col items-center justify-center h-[35vh] border border-neutral-900 mt-5 rounded">
        <h2 class="text-sm lg:text-xl font-medium text-red-400">No snippets yet... 🥲</h2>
    </div>
<?php endif; ?>