$(function() {

    $("a.teams-show").on('click', function(e) {
        e.preventDefault();
        $(this).addClass('hide');
        $("a.teams-hide", $(this).parent()).removeClass('hide');
        $('.teams', $(this).parents('.tournament')).slideDown();
    });

    $("a.teams-hide").on('click', function(e) {
        e.preventDefault();
        $(this).addClass('hide');
        $("a.teams-show", $(this).parent()).removeClass('hide');
        $('.teams', $(this).parents('.tournament')).slideUp();
    });

});
