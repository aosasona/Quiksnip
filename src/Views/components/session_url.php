<form method="POST">
    <div class="flex flex-col gap-2">
        <h3 class="text-lg font-bold m-0 p-0">One-time URL</h3>
        <p class="text-xs text-neutral-600 m-0 p-0">You can share this link with anyone to provide them full access to your snip for 12 hours.</p>
        <div class="w-full h-max whitespace-nowrap relative">
            <div class="w-full bg-neutral-900 text-neutral-500 text-center text-xs text-ellipsis whitespace-nowrap overflow-hidden rounded-lg px-4 py-4">
				<?= $data["session_url"] ?? "No session URL" ?>
            </div>
            <button type="button" class="absolute h-full aspect-square top-0 right-0 bg-neutral-900 hover:bg-green-400 hover:text-neutral-900 border border-neutral-800 rounded-r-lg p-2.5 transition-all"
                    onclick="copyText('<?= $data["session_url"] ?? "" ?>')"><i class="fa fa-copy"></i></button>
        </div>
        <button name="create_session" type="submit" class="btn-primary mt-2">Generate new link</button>
    </div>
</form>
