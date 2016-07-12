$(document).ready(function () {
    var TrolleyManager = new TrolleyManager();

    $('.addProduct button').click(function () {
        var basketId = parseInt($(this).parents('.row').data('basket'));

        TrolleyManager.addBasket(basketId);
    });

    $('.cartProduct a.btn-inverse').click(function (e) {
        e.preventDefault();
    });

    $('.cartProduct a.btn-danger').click(function (e) {
        e.preventDefault();

        var trolleyBasketId = parseInt($(this).parents('.row').data('basket'));

        TrolleyManager.removeBasket(trolleyBasketId);
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

        var trolleyBasketId = parseInt($('#basketRow').data('basketRow'));
        var cookieId = parseInt($(this).parents('li').data('cookie'));

        TrolleyManager.removeCookie(trolleyBasketId, cookieId);
    });

    $('.availableCookies a').click(function (e) {
        e.preventDefault();

        var trolleyBasketId = parseInt($('#basketRow').data('basketRow'));
        var cookieId = parseInt($(this).parents('li').data('cookie'));

        TrolleyManager.addCookie(trolleyBasketId, cookieId);
    });
});
