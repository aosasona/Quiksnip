<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/assets/images/favicon.jpg" type="image/x-icon">
    <script src="/assets/js/main.js" defer></script>
    <script src="https://kit.fontawesome.com/56783586cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/output.css">
    <title>
        <?php echo $title; ?>
    </title>
</head>
<body>
<nav class="fixed top-0 flex items-center justify-between w-screen bg-black bg-opacity-50 backdrop-blur-lg border-b border-b-neutral-800 px-5 py-6 z-[999]">
    <div class="flex items-center gap-2 text-green-300 text-xl">
        <img src="assets/images/Logo.svg" alt="logo" class="w-8 lg:w-10 aspect-square"/>
        <h2 class="font-bold">QuikSnip</h2>
    </div>
    <div class="flex items-center gap-5 lg:gap-6">
        <a href="/explore" target="_blank"
           class="text-neutral-300 text-xs lg:text-sm font-medium block">
            <i class="fa-solid fa-magnifying-glass text-xl"></i>
        </a>
        <a href="https://github.com/aosasona/quiksnip" target="_blank"
           class="text-neutral-300 text-xs lg:text-sm font-medium block">
            <i class="fa-brands fa-github text-2xl"></i>
        </a>
    </div>
</nav>