<div class="w-full h-[35vh] overflow-hidden bg-dark rounded-lg">
    <div class="border-b border-b-neutral-800 py-3">
        <h4 class="text-sm text-neutral-500 text-center">Events</h4>
    </div>
    <div class="h-full overflow-scroll pt-4 pb-12">
		<?php

		if (count($s_logs) == 0) : ?>
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