/**
 * Mise en oeuvre du tri des tableaux sortable
 */
$(function() {
    $("table.sortable").tablesorter();
    $("table.filterable").tablefilter();
    $('.datetimepicker').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        format: 'dd/mm/yyyy hh:ii',
        pickerPosition: 'bottom-left'
    });
    $('.datepicker').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'dd/mm/yyyy',
        pickerPosition: 'bottom-left'
    });
    $('.timepicker').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  0,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0,
        format: 'hh:ii',
        pickerPosition: 'bottom-left'
    });
});
