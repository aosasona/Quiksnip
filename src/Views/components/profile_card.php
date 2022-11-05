<div class="w-full flex justify-end">
    <button @click="open = !open" class="w-max bg-neutral-900 text-neutral-400 bg-opacity-80 lg:hidden text-xs px-5 py-3 rounded-lg mb-2 hover:opacity-50">
        <span x-text="open ? 'Hide highlight' : 'Show highlight'"></span>
    </button>
</div>
<div class="bg-neutral-900 bg-opacity-80 rounded-lg" x-show="open" x-data="{ showModal: false }">
    <div class="w-full flex justify-end border-b border-b-neutral-800 py-3 px-4">
        <button class="text-neutral-400 hover:text-green-400 p-1" @click="showModal = !showModal">
            <i class="fa-solid fa-ellipsis aspect-square"></i>
        </button>
    </div>
    <div class="relative py-8 px-5 lg:px-6">
        <div x-show="showModal" @click.outside="showModal = false" class="absolute right-2 top-2 z-[99] flex gap-2 bg-neutral-800 drop-shadow-lg rounded-lg py-2 px-4">
			<?php
			if (!$is_guest): ?>
                <a href="/profile/edit" class="block text-xs p-2 hover:opacity-50">
                    <i class="fa-solid fa-edit"></i>
                </a>
			<?php endif; ?>

            <a href="/auth/logout" class="block text-xs text-red-600 p-2 hover:opacity-50">
                <i class="fa-solid fa-power-off"></i>
            </a>
        </div>

		<?php if ($is_guest): ?>
            <div class="h-[10vh] lg:h-[15vh] flex items-center justify-center text-center text-sm text-neutral-500">
                <p>You're signed in as a <span class="text-green-400">guest</span></p>
            </div>
		<?php else: ?>
            <div>
                <img src="<?= $user['profile_image'] ?>" class="w-3/6 mx-auto" alt="profile image"/>
                <h3 class="text-center text-neutral-200 text-2xl font-medium my-5"><?= $user["name"] ?></h3>
                <p class="bg-neutral-800 bg-opacity-50 text-neutral-500 text-xs text-center rounded-lg py-3 px-2"><?= $user["bio"] ?></p>
                <div class="grid grid-cols-3 gap-3 py-5 my-2">
                    <div class="col-span-1 space-y-2">
                        <h3 class="text-center text-neutral-200 text-2xl font-medium"><?= $stats["snippets"] ?></h3>
                        <p class="text-neutral-500 text-xs text-center">Snippets</p>
                    </div>
                    <div class="col-span-1 space-y-2">
                        <h3 class="text-center text-neutral-200 text-2xl font-medium"><?= $stats["up_votes"] ?></h3>
                        <p class="text-neutral-500 text-xs text-center">Up-votes</p>
                    </div>
                    <div class="col-span-1 space-y-2">
                        <h3 class="text-center text-neutral-200 text-2xl font-medium"><?= $stats["down_votes"] ?></h3>
                        <p class="text-neutral-500 text-xs text-center">Down-votes</p>
                    </div>
                </div>

				<?php if ($user["github_url"]): ?>
                    <a href="<?= $user['github_url'] ?>"
                       target="_blank" rel="noreferrer noopener"
                       class="block w-full text-center bg-green-400 text-neutral-900 font-medium text-xs py-3 rounded hover:-translate-y-1 transition-all">
                        View on GitHub
                    </a>
				<?php endif; ?>
            </div>
		<?php endif; ?>
    </div>
</div>