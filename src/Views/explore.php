<?php

use Quiksnip\Web\Controllers\ExploreController;
use Quiksnip\Web\Utils\Loader;

$user = \Quiksnip\Web\Utils\Auth::getSessionUser();
$is_guest = isset($_SESSION["is_guest"]) && $_SESSION["is_guest"] === true;
$stats = ExploreController::collectStats($user["email"]);

Loader::startLayout("Explore");
?>
<main class="container w-full flex flex-col lg:flex-row-reverse gap-4 mx-auto mt-[10vh] lg:mt-[14vh]">
    <section class="block w-full lg:w-[30%] h-auto self-start" x-data="{ open: true }">
        <div class="w-full flex justify-end">
            <button @click="open = !open" class="w-max lg:hidden text-xs px-2 py-3 mb-1 hover:opacity-50">
                <span x-text="open ? 'Hide profile' : 'Show profile'"></span>
            </button>
        </div>
        <div class="bg-neutral-900 rounded-lg" x-show="open" x-data="{ showModal: false }">
            <div class="w-full flex justify-end border-b border-b-neutral-800 py-3 px-4">
                <button class="text-neutral-400 hover:text-green-400 p-1" @click="showModal = !showModal">
                    <i class="fa-solid fa-ellipsis aspect-square"></i>
                </button>
            </div>
            <div class="relative py-8 px-5 lg:px-6">
                <div x-show="showModal" @click.outside="showModal = false" class="absolute right-2 top-2 z-[99] flex gap-2 bg-neutral-800 drop-shadow-lg rounded-lg py-2 px-4">
					<?php if (!$is_guest): ?>
                        <a href="/profile/edit" class="block text-xs p-2 hover:opacity-50">
                            <i class="fa-solid fa-edit"></i>
                        </a>
					<?php endif; ?>

                    <a href="/auth/logout" class="block text-xs text-red-600 p-2 hover:opacity-50">
                        <i class="fa-solid fa-power-off"></i>
                    </a>
                </div>

				<?php if ($is_guest): ?>
                    <div class="h-[20vh] flex items-center justify-center text-center text-sm text-neutral-400 p">
                        <p>You're signed in as a <span class="text-green-400">guest</span></p>
                    </div>
				<?php else: ?>
                    <div>
                        <img src="<?= $user['profile_image'] ?>" class="w-3/5 mx-auto" alt="profile image"/>
                        <h3 class="text-center text-neutral-200 text-xl font-medium my-5"><?= $user["name"] ?></h3>
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
                               class="block w-full text-center bg-green-400 text-neutral-900 text-xs py-3 rounded hover:-translate-y-1 transition-all">
                                View on GitHub
                            </a>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </section>


    <section class="w-[65%] lg:h-[80vh]">

    </section>
</main>

<?php
Loader::endLayout();
?>
