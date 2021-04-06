// MENU
$(document).ready(function () {
    $("#menu").click(function () {
        e = $('.sidebar');
        if (e.css("left") == '0px')
            e.css("left", "250px");
        $("#over-sidebar").show();
    });

    $("#over-sidebar").click(function () {
        e = $('.sidebar');
        if (e.css("left") == '250px')
            e.css("left", "0px");
        $("#over-sidebar").hide();
    });
});