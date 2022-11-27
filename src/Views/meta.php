<link rel="stylesheet" href="/assets/css/output.css">
<?php

$s_data = $data["snip_data"];


//if (!$s_data) {
// momentarily disabled
$filename = __DIR__ . "/../../assets/images/default-meta.jpg";
header("Content-Type: image/png");
header("Content-Length: " . filesize($filename));
readfile($filename);
exit;
//}

ob_start();
?>
<div class="flex flex-col h-[300px] aspect-video py-6 px-8 overflow-hidden" style="background: url('/assets/images/meta-bg.png')">
    <div class="flex justify-between gap-4">
        <div class="flex flex-col gap-1 py-2">
            <p class="text-xs text-neutral-500 font-mono">{{username}}/{{slug}}</p>
            <h1 class="font-medium text-4xl">{{title}}</h1>
        </div>
        <img src="{{image}}" alt="{{username}}" class="w-[90px] aspect-square rounded-full">
    </div>
    <div class="flex justify-between items-center mt-auto">
        <div class="flex gap-4 ">
            <p class="text-sm font-mono text-green-400">{{up_votes}} <span class="text-xs text-neutral-500">upvotes</span></p>
            <p class="text-sm font-mono text-green-400">{{down_votes}} <span class="text-xs text-neutral-500">downvotes</span></p>
        </div>
        <p class="text-[9px] font-mono bg-neutral-900 text-neutral-400 px-4 py-2 rounded">{{lang}}</p>
    </div>
</div>
<?php
$meta = ob_get_clean();
$title = strlen($s_data["title"]) > 50 ? substr($s_data["title"], 0, 50) . "..." : $s_data["title"];
$meta = str_replace("{{title}}", $title, $meta);
$meta = str_replace("{{image}}", $s_data["u_image"] ?? "/assets/images/Logo.svg", $meta);
$meta = str_replace("{{up_votes}}", $s_data["up_votes"], $meta);
$meta = str_replace("{{down_votes}}", $s_data["down_votes"], $meta);
$meta = str_replace("{{lang}}", strtoupper($s_data["lang"]), $meta);
$meta = str_replace("{{username}}", $s_data["u_username"], $meta);
$meta = str_replace("{{slug}}", $s_data["slug"], $meta);

header("Content-Type: image/svg+xml");
echo $meta;