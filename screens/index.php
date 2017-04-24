<header class="sm--section__header">
    <?php _nav_menu() ?>
    <h1>Intro</h1>
</header>

<div class="sm--section__main">

    <p>
        This demo shows the basic concept and usage of
        <a href="https://github.com/marianmeres/simple-mockups">Simple Mockups</a>
        &ndash; the ultra simple html based app screen prototyping tool. Read more and check
        the <a href="https://github.com/marianmeres/simple-mockups">source on GitHub</a>.
    </p>

    <hr/>

    <p>
        So, let's pretend we're prototyping a simple music player app...
    </p>

    <div class="nav-placeholder"></div>

    <p><small>
        Note, that the above navigation is generated automatically.
    </small></p>

</div>


<script>
    $(document).one('screen:<?= $id ?>:show', function(e, $section){
        renderDirectChildrenNav('<?= $id ?>', $section.find('.sm--section__main .nav-placeholder'));
    });
</script>



