<?php foreach($baskets as $basket) { /** Basket $basket */?>
    <div class="row addProduct">
        <div class="span3"><strong><?=$basket->getName();?> Basket:</strong> $<?=$basket->getPrice();?> - Holds <?=$basket->getSize();?> items</div>
        <div class="span2"><button class="btn btn-success purchase"><i class="icon-shopping-cart icon-white"></i>Add To Cart</button></div>
        <div class="displayNone basketId"><?=$basket->getId();?></div>
    </div>
    <hr>
<?php } ?>
