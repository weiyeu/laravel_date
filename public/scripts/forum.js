$(function () {
    $('.click-row').click(function () {
        window.location.href = $(this).data('href');
    });
});