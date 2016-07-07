$(document).ready(function () {
    var TrolleyManager = new TrolleyManager();

    $('.addProduct button').click(function () {
        var id = parseFloat($('.basketId', $(this).parents('.row')).html());
        TrolleyManager.addBasket(id);
    });

    $('.cartProduct a.btn-inverse').click(function (e) {
        e.preventDefault();
    });

    $('.cartProduct a.btn-danger').click(function (e) {
        e.preventDefault();

        var key = parseFloat($('.basketKey', $(this).parents('.row')).html());
        TrolleyManager.removeBasket(key);
    });

    $('.cookieThumbs a').live({
        mouseenter: function () {
            $('span', $(this)).stop().fadeTo(300, 1);
        }, mouseleave: function () {
            $('span', $(this)).stop().fadeTo(300, 0);
        }
    });

    $('.basketCookies a').live('click', function (e) {
        e.preventDefault();

        var key = parseFloat($('.basketKey').html());
        var id = parseFloat($('span.cookieId', $(this)).html());

        TrolleyManager.removeCookie(key, id);
    });

    $('.availableCookies a').click(function (e) {
        e.preventDefault();

        var key = parseFloat($('.basketKey').html());
        var id = parseFloat($('span.cookieId', $(this)).html());

        TrolleyManager.addCookie(key, id);
    });
});
