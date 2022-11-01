<?php

use Quiksnip\Quiksnip\Utils\Loader;

Loader::startLayout("Quiksnip");
?>
<main class="container w-[90%] lg:w-screen mx-auto">
    <section class="flex flex-col gap-8 lg:gap-10 items-center lg:justify-center mx-auto mt-[16vh] lg:mt-[22vh]">
        <h1 class="hero-text w-[90%] lg:w-4/5 2xl:w-3/5 text-4xl lg:text-7xl font-black text-center transition-all" id="hero-text">
            Share, edit, and collaborate on code snippets.
        </h1>

        <a href="/auth"
           class="bg-white font-bold text-xs lg:text-sm text-black px-10 py-4 rounded hover:opacity-90 hover:-translate-y-2 transition-all">
            Try it out
        </a>
    </section>

    <img src="assets/images/hero.svg" alt="hero" class="w-[90%] lg:w-4/5 2xl:w-3/5 mx-auto my-16" id="hero-image"/>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-10 mb-8">
        <div class="feature-card">
            <div class="feature-card-icon">
                <i class="fa-solid fa-lock-open icon"></i>
            </div>
            <h3>No authentication required</h3>
            <p>
                Create public editable snippets without having to sign up or log in <span class="font-light italic">(note: the snip will not be owned by you)</span>.
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
<?php
Loader::endLayout();
?>
