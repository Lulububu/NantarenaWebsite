$(document).ready(function () {
    function textChange(){
        var input = $(".follow_content").val();
        $("#banner_data").html(input);
    }
    textChange();

    $('.follow_content').keyup(function(){
        $( "#banner_data" ).html($(this).val());
    });

    $(".follow_content").click(function() {
        $( "#banner_data" ).html($(this).val());
    });

    $('.follow_content').keypress(function(){
        $( "#banner_data" ).html($(this).val());
    });

    $('#follow_content').bind('input propertychange', function() {
        $( "#banner_data" ).html($(this).val());
    });

    $('.follow_content').change(function(){
        $( "#banner_data" ).html($(this).val());
    });
});