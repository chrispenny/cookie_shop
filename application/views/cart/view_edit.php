<?php
use CookieShop\Models\TrolleyBasket;
use CookieShop\Models\Cookie;

/** @var TrolleyBasket $trolleyBasket */
/** @var Cookie[] $cookies */
?>

<div class="hero-unit">
    <p>To <strong>remove</strong> cookies from your Basket, simply click on the cookies image from the list below.</p>
</div>

<div class="row cartProduct" id="basketRow" data-basket="<?php echo $trolleyBasket->getId(); ?>">
    <div class="span12">
        <div class="row">
            <div class="span3" id="basketDetails"><strong><?php echo $trolleyBasket->getBasket()->getName(); ?> Basket</strong> - Holds <?php echo $trolleyBasket->getBasket()->getSize(); ?> items</div>
        </div>
        <div class="row cookieThumbs">
            <div class="span12">
                <ul class="basketCookies">
                    <?php foreach($trolleyBasket->getTrolleyBasketCookieDisplayGroups() as $trolleyBasketCookieDisplayGroup) { ?>
                        <li id="removalId<?php echo $trolleyBasketCookieDisplayGroup->getCookieId(); ?>" data-cookie="<?php echo $trolleyBasketCookieDisplayGroup->getCookieId(); ?>">
                            <span class="cookieQuantity"><?php echo ($trolleyBasketCookieDisplayGroup->countTrolleyBasketCookies() > 1) ? $trolleyBasketCookieDisplayGroup->countTrolleyBasketCookies() . 'x' : ''; ?></span>
                            <a href="#">
                                <span class="btn-danger"><i class="icon-trash icon-white"></i></span>
                                <img src="/assets/img/<?php echo $trolleyBasketCookieDisplayGroup->getCookie()->getImg(); ?>" alt="<?php echo ucwords($trolleyBasketCookieDisplayGroup->getCookie()->getName()); ?>" title="<?php echo ucwords($trolleyBasketCookieDisplayGroup->getCookie()->getName()); ?>">
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <hr>
</div>

<div class="hero-unit">
    <p>To <strong>add</strong> more cookies your Basket, simply click on the cookies image from the list below.</p>
</div>

<div class="row">
    <div class="span12"><strong>Available Cookies:</strong> Click to add to Basket</div>
</div>
<div class="row cookieThumbs">
    <div class="span12">
        <ul class="availableCookies">
            <?php foreach($cookies as $cookie) { ?>
                <li id="availableId<?php echo $cookie->getId(); ?>" data-cookie="<?php echo $cookie->getId(); ?>">
                    <a href="#">
                        <span class="btn-success"><i class="icon-shopping-cart icon-white"></i></span>
                        <img src="/assets/img/<?php echo $cookie->getImg(); ?>" alt="<?php echo ucwords($cookie->getName()); ?>" title="<?php echo ucwords($cookie->getName()); ?>">
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
