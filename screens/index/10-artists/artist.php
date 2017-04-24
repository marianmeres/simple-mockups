<header class="sm--section__header">
    <?php _nav($parentId); ?>
    <h1>Artist: Pearl Jam</h1>
</header>

<div class="sm--section__main">

</div>

<script>
    $(document).one('screen:<?= $id ?>:show', function(e, $section){
        renderDirectChildrenNav('<?= $id ?>', $section.find('.sm--section__main'));
    });
</script>


