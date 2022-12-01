<?php

/**
 * @var $data
 */

$total_pages = $data["total_pages"];
$current_page = $data["current_page"];
$page_title = $page_title ?? "explore";

if ($total_pages > 1): ?>
    <div class="w-full grid grid-cols-3 text-center justify-center mx-auto">
        <div class="self-center text-left">
			<?php if ($current_page > 1):
				$prev_page = $current_page - 1;
				?>
                <a href="/<?= $page_title ?>?page=<?= $prev_page ?>" class="text-xs text-green-400 hover:opacity-50 transition-all px-3 py-1">
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
                <a href="/<?= $page_title ?>?page=<?= $current_page + 1 ?>" class="text-xs text-green-400 hover:opacity-50 transition-all px-3 py-1">
                    <span>Next</span><i class="fas fa-arrow-right ml-1"></i>
                </a>
			<?php endif; ?>
        </div>
    </div>
<?php endif; ?>