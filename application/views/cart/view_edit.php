<?php
use \CookieShop\Model\CookiePeer;

?>

<div class="hero-unit">
    <p>To <strong>remove</strong> cookies from your Basket, simply click on the cookies image from the list below.</p>
</div>

<div class="row cartProduct">
    <div class="span12">
        <div class="row">
            <div class="span3" id="basketDetails"><strong><?= $basket->getName(); ?> Basket</strong> - Holds <?= $basket->getSize(); ?> items</div>
            <div class="displayNone basketKey"><?= $this->uri->segment(3); ?></div>
        </div>
        <div class="row cookieThumbs">
            <div class="span12">
                <ul class="basketCookies">
                    <?php foreach($basket->getCookies() as $id => $quantity) { ?>
                        <?php $cookie = CookiePeer::retrieveByPK($id); ?>

                        <li id="removalId<?= $cookie->getId(); ?>">
                            <span class="cookieQuantity"><?= ($quantity > 1) ? $quantity . 'x' : ''; ?></span>
                            <a href="#">
                                <span class="cookieId displayNone"><?= $cookie->getId(); ?></span>
                                <span class="btn-danger"><i class="icon-trash icon-white"></i></span>
                                <img src="/assets/img/<?= $cookie->getImg(); ?>" alt="<?= ucwords($cookie->getName()); ?>" title="<?= ucwords($cookie->getName()); ?>">
                            </a>
                        </li>
                    <? } ?>
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
                <li id="availableId<?= $cookie->getId(); ?>">
                    <a href="#">
                        <span class="cookieId displayNone"><?= $cookie->getId(); ?></span>
                        <span class="btn-success"><i class="icon-shopping-cart icon-white"></i></span>
                        <img src="/assets/img/<?= $cookie->getImg(); ?>" alt="<?= ucwords($cookie->getName()); ?>" title="<?= ucwords($cookie->getName()); ?>">
                    </a>
                </li>
            <? } ?>
        </ul>
    </div>
</div>
