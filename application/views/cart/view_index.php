<? foreach($cart->getBaskets() as $key => $basket) :?>
    <div class="row cartProduct" id="product<?=$key;?>">
        <div class="span12">
            <div class="row">
                <div class="span3"><strong><?=$basket->getName();?> Basket</strong> - Hold <?=$basket->getSize();?> items</div>
                <div class="span4">
                    <div class="btn-group">
                        <a class="btn btn" href="/cart/edit/<?=$key;?>">
                            <i class="icon-pencil"></i>
                            Edit
                        </a>
                        <!--<a class="btn btn-inverse" href="#">
                            <i class="icon-file icon-white"></i>
                            Duplicate
                        </a>-->
                        <a class="btn btn-danger" href="#">
                            <i class="icon-trash icon-white"></i>
                            Remove
                        </a>
                    </div>
                </div>
                <div class="displayNone basketKey"><?=$key;?></div>
            </div>
            <div class="row cookieThumbs">
                <div class="span12">
                    <ul>
                        <? foreach($basket->getCookies() as $id => $quantity) :?>
                            <? $cookie = \CookieShop\Model\CookiePeer::retrieveByPK($id); ?>

                            <li>
                                <span><?=($quantity > 1) ? $quantity.'x' : '';?></span>
                                <img src="/assets/img/<?=$cookie->getImg();?>" alt="<?=ucwords($cookie->getName());?>" title="<?=ucwords($cookie->getName());?>">
                            </li>
                        <? endforeach;?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <hr>
    </div>
<? endforeach; ?>
