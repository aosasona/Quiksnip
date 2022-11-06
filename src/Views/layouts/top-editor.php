<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Share, edit and collaborate on code snippets.">
    <meta name="keywords" content="quiksnip, ayodeji, osasona, share, code, snippet, javascript, typescript, python, php, rust">
    <meta name="og:title" content="<?= $title ?>">
    <meta name="og:description" content="Share, edit and collaborate on code snippets.">
    <meta name="og:image" content="/assets/images/favicon.jpg">
    <meta name="og:url" content="https://www.quiksnip.dev">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="https://www.quiksnip.dev">
    <meta name="twitter:title" content="<?= $title ?>">
    <meta name="twitter:description" content="Share, edit and collaborate on code snippets.">
    <meta name="twitter:image" content="/assets/images/favicon.jpg">
    <meta name="twitter:creator" content="@trulyao">
    <link rel="icon" href="/assets/images/favicon.jpg" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/56783586cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/output.css">

    <!--  Codemirror  -->
    <link rel=stylesheet href="/assets/js/codemirror/lib/codemirror.css">
    <link rel=stylesheet href="/assets/js/codemirror/theme/material-darker.css">
    <script src="/assets/js/codemirror/lib/codemirror.js"></script>

    <script src="/assets/js/codemirror/addon/edit/matchbrackets.js"></script>
    <!--  Codemirror  -->

    <title>
		<?= $title ?>
    </title>
</head>
<body>
<nav class="fixed top-0 flex items-center justify-between w-screen bg-black bg-opacity-50 backdrop-blur-lg border-b border-b-neutral-800 px-5 py-6 z-[999]">
    <a href="/"
       class="flex items-center gap-2 text-green-400 text-xl">
        <img src="/assets/images/Logo.svg"
             alt="logo"
             class="w-8 lg:w-10 aspect-square"/>
        <h2 class="font-bold tracking-wide">
            QuikSnip
        </h2>
    </a>
    <div class="flex items-center gap-5 lg:gap-6 px-2">
        <a href="/explore"
           target="_blank"
           class="text-neutral-300 text-xs lg:text-sm font-medium block">
            <i class="fa-solid fa-magnifying-glass text-xl"></i>
        </a>
    </div>
</nav>
<main class="container w-full flex flex-col lg:flex-row gap-6 mx-auto mt-[13vh] lg:mt-[14vh]">