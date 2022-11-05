<div>
    <div class="flex justify-between items-center">
        <h1 class="text-4xl lg:text-3xl font-bold text-neutral-200">Explore</h1>
        <a href="/create" class="block bg-green-400 text-[10px] lg:text-xs text-neutral-900 font-medium hover:-translate-y-2 cursor-pointer rounded px-4 py-2 lg:px-5 lg:py-3 transition-all">
            <i class="fa-solid fa-plus mr-1"></i> Create
        </a>
    </div>
    <p class="text-neutral-600 text-sm lg:text-base mt-2">
        Discover latest snippets from the community
    </p>
</div>

<?php if (count($snippets) > 0): ?>
	<?php foreach ($snippets as $snippet): ?>
        <div></div>
	<?php endforeach; ?>
<?php else: ?>
    <div class="flex flex-col items-center justify-center h-[35vh] border border-neutral-900 mt-5 rounded">
        <h2 class="text-sm lg:text-xl font-medium text-red-400">No snippets yet... 🥲</h2>
    </div>
<?php endif; ?>