$(function() {

    /**
     * Affichage/Masquage du formulaire de login
     */
    $("nav#menu .login").click(function() {
        $("nav#menu .loginbox").slideToggle(100);
        $("nav#menu .login").toggleClass("active");
        $("nav#menu .loginbox .username").focus();

        var handler = function(e) {
            if (e.keyCode == 27) {
                $("nav#menu .loginbox").slideUp(100);
                $("nav#menu .login").removeClass("active");
                $(document).off("keydown", handler);
            }
        };

        $(document).on("keydown", handler);
    })

    /**
     * Mise en route des effets bootstrap et jQuery
     */
    $('.carousel').carousel();
    $('.ttip').tooltip();
    $('.datepicker').datepicker();

    /**
     * Flèche scroll-to-top
     */
    $(function() {
        $("#scrolltotop").hide();

        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#scrolltotop').fadeIn();
                } else {
                    $('#scrolltotop').fadeOut();
                }
            });

            $('#scrolltotop a').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
    });
});





