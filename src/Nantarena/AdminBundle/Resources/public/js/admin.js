/**
 * Mise en oeuvre du tri des tableaux sortable
 */
$(function() {
    $("table.sortable").tablesorter();
    $("table.filterable").tablefilter();
    $('.datepicker').datepicker({ dateFormat: "dd/mm/yy" });
});


