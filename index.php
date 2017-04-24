<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Simple Mockups</title>
    <link rel="stylesheet" href="./_assets/bootstrap.min.css">
    <script src="./_assets/jquery-3.1.1.slim.min.js"></script>
    <style>

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sm--header {
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, .1);
            font-size: 1em;
            line-height: 1;
        }

        .sm--header h1 {
            line-height: inherit;
            font-size: inherit;
            margin: 0;
            float: left;
        }

        .sm--header__toc {
            line-height: inherit;
            font-size: inherit;
            float: right;
        }

        .sm--breadcrumb {
            padding: 15px;
            background: none;
            font-size: .9em;
            line-height: 1;
        }

        .sm--main {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 0 15px;
        }

        .sm--footer {
            padding: 15px;
            font-size: .9em;
            width: 100%;
            background: rgba(0,0,0,.05);
        }

        .sm--section {
            margin-bottom: 5rem;
            border: 1px solid rgba(0,0,0,.1);
            border-radius: 5px;
            width: 100%;
            max-width: 640px;
        }

        .sm--section__header {
            background: rgba(0,0,0,.05);
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            padding: 15px;
        }

        .sm--section__header-left {
            float: left;
            line-height: 1;
            padding-right: 15px;
        }


        .sm--section__header-right {
            float: right;
            line-height: 1;
            padding-left: 15px;
        }

        .sm--section__header h1 {
            line-height: 1;
            font-size: 1em;
            margin: 0;
            text-align: left;
            font-weight: bold;
        }

        .sm--section__main {
            padding: 15px;
            min-height: 250px;
        }

        .sm--section__footer {
            padding: 15px;
            border-top: 1px solid rgba(0,0,0,.1);
            text-align: center;
        }

        li {
            margin-top: .3em;
        }

    </style>
    <script>
        var toc = {};
    </script>
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
    $it = new RegexIterator(
        new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)),
        '/.+\.php$/i'
    );
    $lastMod = 0;
    foreach ($it as $f) {
        $lastMod = max($lastMod, filemtime($f));
        _renderSection($f, $dir);
    }
?>
    </main>

    <footer class="sm--footer">
        <span>
            Created by
            <a href="https://github.com/marianmeres">Marian Meres</a>
            with <a href="https://github.com/marianmeres/simple-mockups">Simple Mockups</a>
        </span>
        <span style="float: right">
            Content last updated: <?php echo date('Y-m-d', $lastMod); ?>
        </span>
    </footer>

    <script>

        var $br = $('nav.breadcrumb');

        /**
         * @param currentId
         */
        function renderBreadcrumbs(currentId) {
            $br.html('');
            var path = [];
            currentId.split('_').forEach(function(id, idx){
                path.push(id);
                id = path.join('_');
                if (!toc[id]) return;
                $('<a class="breadcrumb-item" href="#' + id + '">' + toc[id].title + '</a>').appendTo($br);
            });
        }

        /**
         * @param a
         * @param b
         * @returns {number}
         */
        function screenSorter(a, b) {
            if (a.id === 'index') return -1; // initial "index" special case
            if (a.id < b.id) return -1;
            if (a.id > b.id) return 1;
            return 0;
        }

        /**
         * @param parentId
         * @param $container
         */
        function renderDirectChildrenNav(parentId, $container) {
            var parent = toc[parentId];
            if (!parent) return console.error('Parent (' + parentId + ') not found?!');
            if (!$container || !$container.length) return; // valid no-op

            var children = [];
            $.each(toc, function(key, val){
                if (val.parentId === parentId && val.depth === parent.depth + 1) {
                    children.push({id: key, title: toc[key].title})
                }
            });

            if (children.length) {
                $('<b>Navigation</b>').appendTo($container);
                var $ul = $('<ul></ul>').appendTo($container);
                children.sort(screenSorter).forEach(function(o){
                    $('<li><a href="#' + o.id + '">' + o.title + '</a></li>').appendTo($ul);
                })
            }
        }

        /**
         * @param id
         */
        function renderScreen(id) {
            $('section').hide();
            if (id === '') id = 'index';
            var $current = $('#' + id);

            // if showing for the first time, try to render children nav if placeholder is found
            if ($current.length && !$current.data('was-shown')) {
                $current.data('was-shown', true);
                renderDirectChildrenNav(id, $current.find('[data-children-nav-placeholder]'));
            }

            if (!$current.length) {
                $current = $('#_not-found');
                $current.find('h1 span').html('<code>"' + id + '"</code>')
            }

            renderBreadcrumbs(id);
            $current.show();
            toc[id] && (document.title = toc[id].title + " | Simple Mockups");
            $(document).trigger('screen:' + id +':show', [$current]);
        }

        window.onhashchange = function() {
            renderScreen(window.location.hash.substr(1));
        };
        renderScreen(window.location.hash.substr(1));
    </script>

<?php
    // load google analytics if provided
    if (file_exists(__DIR__ . "/_ga.php")) {
        include __DIR__ . "/_ga.php";
    }
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
        // we're saving jQuery's element reference for easier later hackings
        echo "toc['$id'] = {\$el: \$('#$id'), depth: $depth, parentId: '$parentId'}\n";
        echo "toc['$id'].title = toc['$id'].\$el.find('h1').text()\n";
    echo "</script>\n";
    echo "<!-- END: $id -->\n\n";

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