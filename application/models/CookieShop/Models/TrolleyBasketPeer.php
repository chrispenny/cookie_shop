<?php

namespace CookieShop\Models;

class TrolleyBasketPeer
{
    /**
     * @param $id
     * @return TrolleyBasket
     */
    public static function retrieveByPk($id)
    {
        $q = TrolleyBasketQuery::create();
        $q->filterById($id);

        return $q->findOne();
    }
}
