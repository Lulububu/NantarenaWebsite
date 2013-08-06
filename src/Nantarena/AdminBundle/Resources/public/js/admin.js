function admin_init() {
    $("table.sortable").tablesorter();
    $("table.filterable").tablefilter();
}

$(function() {
    admin_init();

    $(".collection_holder").bind('collection_add_clicked', function() {
        datetime_init();
    });
});
