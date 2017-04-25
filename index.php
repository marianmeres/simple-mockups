<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Simple Mockups</title>
    <link rel="stylesheet" href="./_assets/bootstrap.min.css" />
    <script src="./_assets/jquery-3.1.1.slim.min.js"></script>
    <link rel="stylesheet" href="<?php echo _versionize('./_assets/app.css') ?>" />
    <script>var toc = {};</script>
</head>
<body>
    <div class="sm--header clearfix">
        <h1>Simple Mockups Demo</h1>
        <a href="#_toc" class="sm--header__toc">TOC</a>
    </div>

    <nav class="breadcrumb sm--breadcrumb"></nav>

    <main class="sm--main">
    <?php
        $dir = realpath('./screens/');
        $it = new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)), '/.+\.php$/i');
        $lastMod = 0;
        foreach ($it as $f) {
            $lastMod = max($lastMod, filemtime($f));
            _renderSection($f, $dir);
        }
    ?>
    </main>

    <footer class="sm--footer">
        <small>
            Created with <a href="https://github.com/marianmeres/simple-mockups">Simple Mockups</a>
        </small>
        <span style="float: right">
            Content last updated: <?php echo date('Y-m-d', $lastMod); ?>
        </span>
    </footer>

    <script src="<?php echo _versionize('./_assets/app.js') ?>"></script>

    <?php
        // load google analytics if provided
        if (file_exists(__DIR__ . "/_ga.php")) include __DIR__ . "/_ga.php";
    ?>

</body>
</html>

<?php

    // local helper to isolate include scope
    function _renderSection($f, $baseDir) {
        $id = substr($f, strlen($baseDir) + 1, -4); // strip base and extension

        $parentId = dirname($id);
        $parentId = ($parentId == '.') ? 'index' : strtr($parentId, DIRECTORY_SEPARATOR, "_"); // replace slash for "_"

        $depth = substr_count($id, DIRECTORY_SEPARATOR);
        $id = strtr($id, DIRECTORY_SEPARATOR, "_"); // replace slash for "_"

        echo "\n\n<!-- BEGIN: $id -->\n";
        echo "<section id='$id' class='sm--section' style='" . ($id == 'index' ? '' : 'display:none;') . "'>";
            // $id, $parentId and $depth are "globaly" available in each included php file
            include $f;
        echo "</section>\n";
        echo "<script>\n";
            // we're saving jQuery's section reference for easier later hackings
            echo "toc['$id'] = {\$el: \$('#$id'), depth: $depth, parentId: '$parentId'}\n";
            echo "toc['$id'].title = toc['$id'].\$el.find('h1').text()\n";
        echo "</script>\n";
        echo "<!-- END: $id -->\n\n";

    }

    //
    function _versionize($f) {
        return $f . "?v=" . substr(md5_file($f), 0, 6);
    }

    // quick-n-dirty view helpers
    function _nav_back() {
        ?><a href="javascript:history.back()" class="sm--section__header-left" title="Go back">&larr;</a><?php
    }

    function _nav_parent($parentId) {
        ?><a href="#<?= $parentId ?>" class="sm--section__header-left" title="Go up in hierarchy">&uarr;</a><?php
    }

    function _nav_menu() {
        ?><a href="#menu" class="sm--section__header-right">&#x2630;</a><?php
    }

    function _nav($parentId) {
        _nav_back();
        _nav_parent($parentId);
        _nav_menu();
    }