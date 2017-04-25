
var $breadcrumbs = $('nav.breadcrumb');

/**
 * @param currentId
 */
function renderBreadcrumbs(currentId) {
    $breadcrumbs.html('');
    var path = [];
    currentId.split('_').forEach(function(id, idx){
        path.push(id);
        id = path.join('_');
        if (!toc[id]) return;
        $('<a class="breadcrumb-item" href="#' + id + '">' + toc[id].title + '</a>').appendTo($breadcrumbs);
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

// render now
renderScreen(window.location.hash.substr(1));

// render on hash change
window.onhashchange = function() {
    renderScreen(window.location.hash.substr(1));
};