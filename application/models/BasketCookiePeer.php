<?php

namespace CookieShop\Model;

use CookieShop\Model\om\BaseBasketCookiePeer;

class BasketCookiePeer extends BaseBasketCookiePeer
{
    /**
     * @param int $basketId
     * @return BasketCookie[]
     */
    public static function retrieveByBasketId($basketId)
    {
        $q = BasketCookieQuery::create();
        $q->filterByBasketId($basketId);

        return $q->find();
    }
}
