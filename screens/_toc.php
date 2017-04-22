<header class="sm--section__header"><h1>
    Table of Contents
</h1></header>

<div class="sm--section__main"></div>

<script>

    $(document).one('screen:<?= $id ?>:show', function(e, $section){

        var _toc = [];
        $.each(toc, function(key, val){
            if (/^_/.test(key)) return; // skip beginning with "_"
            _toc.push({id: key, depth: val.depth, title: toc[key].title}); // clone
        });

        function _sorter(a, b) {
            if (a.id === 'index') return -1; // initial "index" special case
            if (a.id < b.id) return -1;
            if (a.id > b.id) return 1;
            return 0;
        }

        function _renderLis(parent, $container) {
            var $li = $('<li><a href="#' + parent.id + '">' + parent.title + '</a></li>').appendTo($container);
            var rx = new RegExp('^' + parent.id + "_");
            var children = _toc.filter(function(o) {
                return ( o.depth === parent.depth + 1 && rx.test(o.id) );
            });
            if (children.length) {
                var $ul = $('<ol/>').appendTo($li);
                children
                    .sort(_sorter)
                    .forEach(function(o) { _renderLis(o, $ul); });
            }

        }

        var $ul = $('<ol/>').appendTo($section.find('.sm--section__main'));
        _toc
            .filter(function(o){ return !o.depth; }) // top level only
            .sort(_sorter)
            .forEach(function(o){ _renderLis(o, $ul) }); // recurse if needed

    })

</script>
