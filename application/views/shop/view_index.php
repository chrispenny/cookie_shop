<?php foreach($baskets as $basket) { /** Basket $basket */ ?>
    <div class="row addProduct" data-basket="<?php echo $basket->getId(); ?>">
        <div class="span3">
            <strong><?php echo $basket->getName(); ?> Basket:</strong> $<?php echo $basket->getPrice(); ?> - Holds <?php echo $basket->getSize(); ?> items
        </div>
        <div class="span2">
            <button class="btn btn-success purchase"><i class="icon-shopping-cart icon-white"></i>Add To Cart</button>
        </div>
    </div>

    <hr>
<?php } ?>
