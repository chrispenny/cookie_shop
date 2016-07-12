<?php

namespace CookieShop\Models;

use CookieShop\Models\Base\Trolley as BaseTrolley;

class Trolley extends BaseTrolley
{
    /**
     * @param Basket $basket
     */
    public function addBasket(Basket $basket)
    {
        $trolleyBasket = new TrolleyBasket();
        $trolleyBasket->setBasket($basket);

        // set the default cookies into the basket
        foreach ($basket->getBasketCookies() as $basketCookie) {
            $trolleyBasketCookie = new TrolleyBasketCookie();
            $trolleyBasketCookie->setCookie($basketCookie->getCookie());

            $trolleyBasket->addTrolleyBasketCookie($trolleyBasketCookie);
        }

        $this->addTrolleyBasket($trolleyBasket);
    }

    /**
     * @param TrolleyBasket $trolleyBasket
     * @return Trolley
     */
    public function removeTrolleyBasket(TrolleyBasket $trolleyBasket)
    {
        foreach ($trolleyBasket->getTrolleyBasketCookies() as $trolleyBasketCookie) {
            $trolleyBasket->removeTrolleyBasketCookie($trolleyBasketCookie);
        }

        return parent::removeTrolleyBasket($trolleyBasket);
    }
}
