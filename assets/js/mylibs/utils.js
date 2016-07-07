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

    this.addBasket = function (id) {
        $.post('/ajax/add_basket/', {
            id: id
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

    this.removeBasket = function (key) {
        $.post('/ajax/remove_basket/', {
            key: key
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.removeBasketRow(key);
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

    this.addCookie = function (key, id) {
        var info;

        $.post('/ajax/add_cookie/', {
            key: key,
            id: id
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.addCookieRow(id, data['quantity']);
            } else if (data['status'] == 2) {
                if (data['nextBasket'] !== null) {
                    this.increaseBasketSizePrompt(data['nextBasket'], key, id);
                } else {
                    info = {
                        'heading': 'Error',
                        'message': data['message'],
                        'link': false
                    };

                    this.showMessage(info);
                }
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

    this.removeCookie = function (key, id) {
        $.post('/ajax/remove_cookie/', {
            key: key,
            id: id
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                if (data['quantity'] == 0) {
                    $('#removalId' + id).fadeTo(300, 0, function () {
                        $(this).remove();
                    });
                } else {
                    var quantity = (data['quantity'] >= 2) ? data['quantity'] + 'x' : '';
                    $('#removalId' + id + ' .cookieQuantity').html(quantity);
                }

                if (data['prevBasket'] != null) {
                    this.reduceBasketSizePrompt(data['prevBasket']);
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

    this.addCookieRow = function (id, quantity) {
        if ($('#removalId' + id).length == 1) {
            $('.cookieQuantity', $('#removalId' + id)).html(quantity + 'x');
        } else {
            var span = $('<span></span>');
            span.addClass('cookieQuantity');

            var newRow = $('#availableId' + id).clone();
            newRow.remove('#availableId' + id).attr('id', 'removalId' + id).prepend(span);

            $('span.btn-success', newRow).removeClass('btn-success').addClass('btn-danger');
            $('i.icon-shopping-cart', newRow).removeClass('icon-shopping-cart').addClass('icon-trash');

            $('span:not(.cookieQuantity)', newRow).fadeTo(0, 0);

            newRow.appendTo('.basketCookies');
        }
    };

    this.reduceBasketSizePrompt = function (basket) {
        var message = 'This Basket is now small enough to be downsized to a ' + basket['name'] + ' Basket.<br />';
        message += '<strong>' + basket['name'] + ' Basket:</strong> $' + basket['price'] + ' - Holds ' + basket['size'] + ' items</p>';
        message += '<p>Would you like to downsize your Basket?</p>';

        this.showChoice(message);

        $('#modalChoice .btn-success').unbind().click(function () {
            this.changeBasketSize(basket);
        });

        $('#modalChoice .btn-danger').click(function () {
            this.close();
        });
    };

    this.increaseBasketSizePrompt = function (basket, key, id) {
        var message = 'You cannot fit any more cookies in your ' + $('#basketDetails strong').html() + '.<br />';
        message += '<strong>' + basket['name'] + ' Basket:</strong> $' + basket['price'] + ' - Holds ' + basket['size'] + ' items</p>';
        message += '<p>Would you like to increase the size of your Basket?</p>';

        this.showChoice(message);

        $('#modalChoice .btn-success').unbind().click(function () {
            this.changeBasketSize(basket, key, id);
        });

        $('#modalChoice .btn-danger').click(function () {
            this.close();
        });
    };

    this.changeBasketSize = function (basket, key, id) {
        key = typeof key !== 'undefined' ? key : null;
        id = typeof id !== 'undefined' ? id : null;

        $.post('/ajax/set_basket_type/', {
            key: basket['key'],
            type: basket['type']
        }, function (response) {
            var data = eval('(' + response + ')');

            if (data['status'] == 1) {
                this.changeBasketDetails(basket);

                if (key !== null && id !== null) {
                    this.addCookie(key, id);
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

    this.removeBasketRow = function (key) {
        $('.cartProduct#product' + key).fadeOut();
    };

    this.changeBasketDetails = function (basket) {
        $('#basketDetails').html('<strong>' + basket['name'] + ' Basket</strong> - Holds ' + basket['size'] + ' items');
    };

    this.checkCartCount = function () {
        $.get('/ajax/check_cart_count/', function (response) {
            response = parseFloat(response);

            if (response > 0) {
                $('#cartCount').html('Items in cart: ' + response);
            } else {
                $('#cartCount').html('Cart is empty');
            }
        });
    };
};
