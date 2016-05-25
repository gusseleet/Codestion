$(document).ready(function()
{
    $('.message').each(function() {

        $(this).delay(1000).fadeOut(4000, function () {
            $(this).remove();
        });
    });
});