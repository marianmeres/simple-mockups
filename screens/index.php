<header class="wf--section__header">
    <a href="#menu" class="wf--section__header-right">&#x2630;</a>
    <h1>Intro</h1>
</header>

<div class="wf--section__main">

    <p>
        This demo shows the basic concept and usage of <a target="_blank"
        href="https://github.com/marianmeres/simple-mockups">Simple Mockups</a>
        &ndash; the html based app screen prototyping tool. Main features are:
    </p>

    <ul>
        <li>each mockup screen == single file</li>
        <li>navigation between screens via <code>href="#screen-id"</code></li>
        <li>screen hierarchy automatically generated from filesystem</li>
        <li>trivial PHP server side rendering (single file, &plusmn;20 lines of code)</li>
        <li>table of contents automatically generated</li>
        <li>everything fully and easily hackable (js, html, css, php)</li>
        <li>not intended as a visual prototyping tool (although possible)</li>
    </ul>

    <p>
        So, let's pretend we're prototyping a simple music app. The navigation flow
        of our app may look like this:
    </p>

    <ul>
        <li><a href="#<?= $id ?>_10-artists">Artists</a></li>
        <li><a href="#<?= $id ?>_20-albums">Albums</a></li>
        <li><a href="#<?= $id ?>_30-songs">Songs</a></li>
    </ul>

</div>




