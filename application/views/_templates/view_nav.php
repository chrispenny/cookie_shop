<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="/">Cookie Shop</a>
            <a class="brand right" id="cartCount" href="/cart/">
                <?php if ($trolley->countTrolleyBaskets() > 0) { ?>
                    Items in cart: <?php echo $trolley->countTrolleyBaskets(); ?>
                <?php } else { ?>
                    Cart is empty
                <?php } ?>
            </a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="/">Shop</a></li>
                    <li><a href="/cart">Cart</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
