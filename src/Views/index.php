<?php

namespace Quiksnip\Web\Views;

use Quiksnip\Web\Utils\Loader;

Loader::startLayout("Quiksnip");
?>
<main class="container w-[92%] lg:w-screen mx-auto">
    <section class="flex flex-col gap-8 lg:gap-14 items-center lg:justify-center mx-auto mt-[15vh] lg:mt-[22vh]">
        <h1 class="hero-text lg:w-5/6 2xl:w-3/5 text-4xl lg:text-7xl font-bold text-center tracking-wide transition-all" id="hero-text">
            Share, fix &amp; collaborate on code snippets.
        </h1>

        <div>
            <a href="/auth" class="bg-white block font-bold text-xs lg:text-sm text-black px-6 lg:px-10 py-3 lg:py-4 rounded-lg hover:opacity-90 hover:-translate-y-2 transition-all">
                Try it now <i class="fa-solid fa-arrow-right ml-1.5"></i>
            </a>
            <p class="text-[10px] text-center text-neutral-500 mt-3">Don't worry, it's free :)</p>
        </div>
    </section>

    <img src="assets/images/hero.svg" alt="hero" class="w-[90%] lg:w-4/5 2xl:w-3/5 mx-auto my-12 lg:my-24" id="hero-image" />

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 mb-8">
        <div class="feature-card">
            <div class="feature-card-icon">
                <i class="fa-solid fa-lock-open icon"></i>
            </div>
            <h3>No authentication required</h3>
            <p>
                Create public editable snippets without having to sign up or log in (fair warning: you will not own the snippet).
            </p>
        </div>
        <div class="feature-card">
            <div class="feature-card-icon">
                <i class="fa-solid fa-globe icon"></i>
            </div>
            <h3>Browse snippets</h3>
            <p>
                Browse through, contribute to and use <i>public</i> snippets created by other users.
            </p>
        </div>
        <div class="feature-card col-">
            <div class="feature-card-icon">
                <i class="fa-solid fa-arrow-pointer icon"></i>
            </div>
            <h3>Track activity</h3>
            <p>
                View detailed logs of all the edits made to your snippets (if you sent a link to someone, you can see what they did and when they accessed it).
            </p>
        </div>
        <div class="feature-card col-">
            <div class="feature-card-icon">
                <i class="fa-solid fa-comment icon"></i>
            </div>
            <h3>Engage in discussions</h3>
            <p>
                Leave comments on other users' snippets and get feedback on your code to improve it, or just to learn from others.
            </p>
        </div>
    </section>
</main>
<script src="/assets/js/main.js" defer></script>
<?php
Loader::endLayout();
?>
