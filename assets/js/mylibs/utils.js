Overlay = function () {
    this.showMessage = function (info) {
        $('#modalWindow h3').html(info['heading']);
        $('#modalWindow #modalMessage').html(info['message']);
        if (info['link']) {
            $('#modalWindow a').attr('href', info['link']).html(info['link_text']);
        } else {
            $('#modalWindow a').hide();
        }

        $.fancybox({
            href: '#modalWindow',
            modal: false
        });
    };

    this.showChoice = function(message) {
        $('#modalChoice #modalMessage').html(message);

        $.fancybox({
            href: '#modalChoice',
            modal: false
        });
    };

    this.close = function() {
        $.fancybox.close();
    }
};

TrolleyManager = function () {
    $.extend(this, new Overlay());

    this.addBasket = function (basketId) {
        $.post('/ajax/add_basket/', {
            basketId: basketId
        }, function (response) {
            var data = eval('(' + response + ')');
            var info;

            if (data['status'] == 1) {
                info = {
                    'heading': 'Success',
                    'message': data['message'],
                    'link': '/cart/',
                    'link_text': 'Go To Cart'
                };

                this.showMessage(info);
                this.checkCartCount();
            } else {
                info = {
                    'heading': 'Error',
                    'message': data['message'],
                    'link': false
                };

                this.showMessage(info);
            }
        });
    };

    this.removeBasket = function (trolleyBasketId) {
        $.post('/ajax/remove_basket/', {
            trolleyBasketId: trolleyBasketId
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.removeBasketRow(trolleyBasketId);
                this.checkCartCount();
            } else {
                var info = {
                    'heading': 'Error',
                    'message': data['message'],
                    'link': false
                };

                this.showMessage(info);
            }
        });
    };

    this.addCookie = function (trolleyBasketId, cookieId) {
        var info;

        $.post('/ajax/add_cookie/', {
            trolleyBasketId: trolleyBasketId,
            cookieId: cookieId
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.addCookieRow(cookieId, data['quantity']);
            } else if (data['status'] == 2) {
                this.increaseBasketSizePrompt(data['nextBasket'], trolleyBasketId, cookieId);
            } else {
                info = {
                    'heading': 'Error',
                    'message': data['message'],
                    'link': false
                };

                this.showMessage(info);
            }
        });
    };

    this.removeCookie = function (trolleyBasketId, cookieId) {
        $.post('/ajax/remove_cookie/', {
            trolleyBasketId: trolleyBasketId,
            cookieId: cookieId
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] > 0) {
                if (data['quantity'] == 0) {
                    $('#removalId' + cookieId).fadeTo(300, 0, function () {
                        $(this).remove();
                    });
                } else {
                    var quantity = (data['quantity'] >= 2) ? data['quantity'] + 'x' : '';
                    $('#removalId' + cookieId + ' .cookieQuantity').html(quantity);
                }

                if (data['status'] == 2) {
                    this.reduceBasketSizePrompt(data['prevBasket'], trolleyBasketId);
                }
            } else {
                var info = {
                    'heading': 'Error',
                    'message': data['message'],
                    'link': false
                };

                this.showMessage(info);
            }
        });
    };

    this.addCookieRow = function (cookieId, quantity) {
        var existingRow = $('#removalId' + cookieId);

        if (existingRow.length == 1) {
            $('.cookieQuantity', existingRow).html(quantity + 'x');
        } else {
            var span = $('<span></span>');
            span.addClass('cookieQuantity');

            var newRow = $('#availableId' + cookieId).clone();
            newRow.remove('#availableId' + cookieId).attr('id', 'removalId' + cookieId).prepend(span);

            $('span.btn-success', newRow).removeClass('btn-success').addClass('btn-danger');
            $('i.icon-shopping-cart', newRow).removeClass('icon-shopping-cart').addClass('icon-trash');

            $('span:not(.cookieQuantity)', newRow).fadeTo(0, 0);

            newRow.appendTo('.basketCookies');
        }
    };

    this.reduceBasketSizePrompt = function (basket, trolleyBasketId) {
        var message = 'This Basket is now small enough to be downsized to a ' + basket['name'] + ' Basket.<br />';
        message += '<strong>' + basket['name'] + ' Basket:</strong> $' + basket['price'] + ' - Holds ' + basket['size'] + ' items</p>';
        message += '<p>Would you like to downsize your Basket?</p>';

        this.showChoice(message);

        $('#modalChoice .btn-success').unbind().click(function () {
            this.changeBasketSize(basket, trolleyBasketId);
        });

        $('#modalChoice .btn-danger').click(function () {
            this.close();
        });
    };

    this.increaseBasketSizePrompt = function (basket, trolleyBasketId, cookieId) {
        var message = 'You cannot fit any more cookies in your ' + $('#basketDetails strong').html() + '.<br />';
        message += '<strong>' + basket['name'] + ' Basket:</strong> $' + basket['price'] + ' - Holds ' + basket['size'] + ' items</p>';
        message += '<p>Would you like to increase the size of your Basket?</p>';

        this.showChoice(message);

        $('#modalChoice .btn-success').unbind().click(function () {
            this.changeBasketSize(basket, trolleyBasketId, cookieId);
        });

        $('#modalChoice .btn-danger').click(function () {
            this.close();
        });
    };

    this.changeBasketSize = function (basket, trolleyBasketId, cookieId) {
        trolleyBasketId = typeof trolleyBasketId !== 'undefined' ? trolleyBasketId : null;
        cookieId = typeof cookieId !== 'undefined' ? cookieId : null;

        $.post('/ajax/set_basket_type/', {
            trolleyBasketId: trolleyBasketId,
            basketId: basket['basketId']
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.changeBasketDetails(basket);

                if (trolleyBasketId !== null && cookieId !== null) {
                    this.addCookie(trolleyBasketId, cookieId);
                }

                this.close();
            } else {
                var info = {
                    'heading': 'Error',
                    'message': data['message'],
                    'link': false
                };

                this.showMessage(info);
            }
        });
    };

    this.removeBasketRow = function (trolleyBasketId) {
        $('.cartProduct#product' + trolleyBasketId).fadeOut();
    };

    this.changeBasketDetails = function (basket) {
        $('#basketDetails').html('<strong>' + basket['name'] + ' Basket</strong> - Holds ' + basket['size'] + ' items');
    };

    this.checkCartCount = function () {
        $.get('/ajax/check_cart_count/', function (response) {
            response = parseInt(response);

            if (response > 0) {
                $('#cartCount').html('Items in cart: ' + response);
            } else {
                $('#cartCount').html('Cart is empty');
            }
        });
    };
};
