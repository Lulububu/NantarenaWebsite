function admin_init() {
    $("table.sortable").tablesorter();
    $("table.filterable").tablefilter();
}

$(function() {
    admin_init();

    // transforme le curseur en pointer pour indiquer qu'une action est
    // faisable sur la cellule de tête du tableau
    $("[data-sort] th").css('cursor', 'pointer');

    $("table.filterable").bind('filterUpdate', function() {
        $('abbr, .ttip').tooltip();
        datetime_init();
    });

    $("table.sortable").bind('sortEnd', function() {
        $('abbr, .ttip').tooltip();
    });

    $(".collection_holder").bind('collection_add_clicked', function() {
        datetime_init();
    });
});
