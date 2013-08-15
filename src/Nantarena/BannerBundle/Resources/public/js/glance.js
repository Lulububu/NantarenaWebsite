$(document).ready(function () {
    function textChange(){
        var input = $(".follow_content").val();
        $("#banner-data").html(input);
    }
    textChange();

    $('.follow_content').keyup(function(){
        $( "#banner-data" ).html($(this).val());
    });

    $(".follow_content").click(function() {
        $( "#banner-data" ).html($(this).val());
    });

    $('.follow_content').keypress(function(){
        $( "#banner-data" ).html($(this).val());
    });

    $('#follow_content').bind('input propertychange', function() {
        $( "#banner-data" ).html($(this).val());
    });

    $('.follow_content').change(function(){
        $( "#banner-data" ).html($(this).val());
    });
});