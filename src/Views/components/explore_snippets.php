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
    <a href="/new" class="fixed lg:relative bottom-6 right-6 lg:bottom-0 lg:right-0 lg:block bg-green-400 text-[10px] text-neutral-900 font-medium hover:-translate-y-2 cursor-pointer rounded-md lg:rounded p-5 lg:p-0 lg:py-2 lg:px-3 my-0 transition-all">
        <i class="fa-solid fa-plus text-xl lg:text-sm"></i>
    </a>
</div>

<?php $search_target = "/explore" . http_build_query([
    "user" => $q_username ?? null,
    "lang" => $q_lang ?? null
]); ?>

<form action="<?= $search_target ?>" method="GET" class="flex gap-2 mt-3">
    <input type="search" value="<?= $q_search ?? "" ?>" name="q" placeholder="Search" />
    <button type="submit" class="bg-green-400 hover:bg-green-600 text-neutral-900 px-5 rounded-lg">
        <i class="fa-solid fa-search"></i>
    </button>
</form>

<div x-data="{ showFilters: <?= $q_lang ? 'true' : 'false' ?> }" class="mt-3.5">
    <div class="flex w-full justify-end p-0 m-0">
        <button x-show="!showFilters" x-on:click="showFilters = !showFilters" class="text-sm text-green-400 hover:text-green-600 mt-3">
            <i class="fa fa-filter"></i> Filter
        </button>
    </div>
    <form action="/explore" method="GET" id="lang-filter" x-show="showFilters" class="w-full">
        <div class="flex items-center gap-4">
            <p class="text-xs whitespace-nowrap">Filter by language</p>
            <select name="lang" id="language" title="Snippet's language" class="w-full" onchange="$('#lang-filter').submit()">
                <?php
                foreach ($languages as $key => $value) {
                    $selected = $key === ($q_lang ?? "javascript") ? "selected" : "";
                    $name = $value["name"];
                    echo "<option value=\"{$key}\" {$selected}>{$name}</option>";
                }
                ?>
            </select>
        </div>
        <div class="w-full text-right mt-2">
            <a href="/explore" class="text-xs text-green-400 hover:underline hover:underline-offset-2 transition-all">
                Reset filter(s)
            </a>
        </div>
    </form>
</div>


<?php
/** @var $snippets
 * @var $languages
 */
if (count($snippets ?? []) > 0) : ?>
    <div class="grid grid-cols-1 gap-3 mt-5">
        <?php require __DIR__ . "/snippet_card.php" ?>
    </div>
<?php else : ?>
    <div class="flex flex-col items-center justify-center h-[35vh] border border-neutral-900 mt-5 rounded">
        <h2 class="text-sm lg:text-xl font-medium text-red-400">No snippets... 🥲</h2>
    </div>
<?php endif; ?>
