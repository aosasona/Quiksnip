<?php foreach ($snippets as $snippet) : ?>
    <div class="snippet-card">
        <a href="/s/<?= $snippet['slug'] ?>" class="title text-left">
			<?= ucfirst($snippet['title']) ?>
        </a>
        <div class="flex justify-between items-center">
            <p class="text-[10px] text-neutral-600"><?= \Quiksnip\Web\Utils\Misc::timeAgo($snippet["created_at"]) ?></p>
            <a class="outline-none hover:no-underline" href="?lang=<?= $snippet["lang"] ?>">
                <p class="w-max text-[8px] lg:text-[10px] font-medium bg-opacity-80 rounded px-1.5 py-1" style="background-color: <?= $languages[strtolower($snippet["lang"])]["bg"] ?>;
                        color: <?= $languages[strtolower($snippet["lang"])]["text"] ?>">
                    <span class="tracking-wider uppercase"><?= $snippet['lang'] ?></span>
                </p>
            </a>
        </div>
    </div>
<?php endforeach; ?>