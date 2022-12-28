<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Share, edit and collaborate on code snippets.">
    <meta name="keywords" content="quiksnip, ayodeji, osasona, share, code, snippet, javascript, typescript, python, php, rust, snippets, sql, julia, r">
    <meta name="og:title" content="Admin | QuikSnip">
    <meta name="og:description" content="Share, edit and collaborate on code snippets.">
    <meta name="og:image" content="/assets/images/default-meta.jpg">
    <meta name="og:url" content="https://www.quiksnip.dev">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="https://www.quiksnip.dev">
    <meta name="twitter:title" content="Admin | QuikSnip">
    <meta name="twitter:description" content="Share, edit and collaborate on code snippets.">
    <meta name="twitter:image" content="/assets/images/default-meta.jpg">
    <meta name="twitter:creator" content="@trulyao">
    <link rel="icon" href="/assets/images/favicon.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/56783586cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/output.css">
    <title>
        Admin - Quiksnip
    </title>
</head>

<body>

<?php if (!$_SESSION["admin_logged_in"]): ?>
    <main>
        <form class="max-w-md">
            <input type="password"/>
        </form>
    </main>
	<?php exit; endif; ?>

</body>
</html>
