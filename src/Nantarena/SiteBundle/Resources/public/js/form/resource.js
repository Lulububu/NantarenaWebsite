$(function() {

    $("body").on('click', ".resource-widget .upload", function(e) {
        e.preventDefault();
        $("input[type=file]", $(this).parents(".resource-widget")).click();
    });

    $("body").on('change', ".resource-widget input[type=file]", function(e) {
        var file = $(this).prop('files')[0];
        $(".name .temp", $(this).parents(".resource-widget")).text(file.name);
        $("input[type=hidden]", $(this).parents(".resource-widget")).val(file.name);

        $(".name a", $(this).parents(".resource-widget")).addClass('hide');
        $(".name .empty", $(this).parents(".resource-widget")).addClass('hide');
        $(".name .temp", $(this).parents(".resource-widget")).removeClass('hide');

        $(".delete", $(this).parents(".resource-widget")).removeClass('hide');
    });

    $("body").on('click', ".resource-widget .delete", function(e) {
        e.preventDefault();
        $(this).addClass('hide');

        $("input[type=hidden]", $(this).parents(".resource-widget")).val('');
        $(".name a", $(this).parents(".resource-widget")).addClass('hide');
        $(".name .empty", $(this).parents(".resource-widget")).removeClass('hide');
        $(".name .temp", $(this).parents(".resource-widget")).addClass('hide');
    });
});
