<?php
use CookieShop\Models\Trolley;

/** @var Trolley $trolley */

?>

<?php foreach($trolley->getTrolleyBaskets() as $trolleyBasket) { ?>
    <div class="row cartProduct" id="product<?php echo $trolleyBasket->getId(); ?>" data-basket="<?php echo $trolleyBasket->getId(); ?>">
        <div class="span12">
            <div class="row">
                <div class="span3"><strong><?php echo $trolleyBasket->getBasket()->getName(); ?> Basket</strong> - Hold <?php echo $trolleyBasket->getBasket()->getSize(); ?> items</div>
                <div class="span4">
                    <div class="btn-group">
                        <a class="btn btn" href="/cart/edit/<?php echo $trolleyBasket->getId(); ?>">
                            <i class="icon-pencil"></i>
                            Edit
                        </a>
                        <a class="btn btn-danger" href="#">
                            <i class="icon-trash icon-white"></i>
                            Remove
                        </a>
                    </div>
                </div>
            </div>
            <div class="row cookieThumbs">
                <div class="span12">
                    <ul>
                        <?php foreach($trolleyBasket->getTrolleyBasketCookieDisplayGroups() as $trolleyBasketCookieDisplayGroup) { ?>
                            <li>
                                <span><?php echo ($trolleyBasketCookieDisplayGroup->countTrolleyBasketCookies() > 1) ? $trolleyBasketCookieDisplayGroup->countTrolleyBasketCookies() . 'x' : ''; ?></span>
                                <img src="/assets/img/<?php echo $trolleyBasketCookieDisplayGroup->getCookie()->getImg(); ?>" alt="<?php echo ucwords($trolleyBasketCookieDisplayGroup->getCookie()->getName()); ?>" title="<?php echo ucwords($trolleyBasketCookieDisplayGroup->getCookie()->getName()); ?>">
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <hr>
    </div>
<?php } ?>
