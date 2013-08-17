function admin_init() {
    $("table.sortable").tablesorter();
    $("table.filterable").tablefilter();
}

$(function() {
    admin_init();

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
