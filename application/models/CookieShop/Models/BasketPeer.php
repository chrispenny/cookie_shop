<?php

namespace CookieShop\Models;

class BasketPeer
{
    /**
     * @param $id
     * @return Basket
     */
    public static function retrieveByPk($id)
    {
        $q = BasketQuery::create();
        $q->filterById($id);

        return $q->findOne();
    }

    /**
     * @return Basket[]
     */
    public static function retrieveBaskets()
    {
        $q = BasketQuery::create();
        $q->orderBySize();

        return $q->find();
    }

    /**
     * @param Basket $basket
     * @return Basket
     */
    public static function getNextBasketSize(Basket $basket)
    {
        $q = BasketQuery::create();
        $q->filterBySize($basket->getSize(), \Criteria::GREATER_THAN);
        $q->orderBySize(\Criteria::ASC);

        return $q->findOne();
    }

    /**
     * @param Basket $basket
     * @return Basket
     */
    public static function getPrevBasketSize(Basket $basket)
    {
        $q = BasketQuery::create();
        $q->filterBySize($basket->getSize(), \Criteria::LESS_THAN);
        $q->orderBySize(\Criteria::DESC);

        return $q->findOne();
    }

    /**
     * @param Basket $basket
     * @return array|null
     */
    public static function getNextBasketSizeAsArray(Basket $basket)
    {
        $basket = self::getNextBasketSize($basket);

        if ($basket !== null) {
            return array(
                'basketId' => $basket->getId(),
                'name' => $basket->getName(),
                'size' => $basket->getSize(),
                'price' => $basket->getPrice(),
            );
        }

        return null;
    }

    /**
     * @param Basket $basket
     * @return array|null
     */
    public static function getPrevBasketSizeAsArray(Basket $basket)
    {
        $basket = self::getPrevBasketSize($basket);

        if ($basket !== null) {
            return array(
                'basketId' => $basket->getId(),
                'name' => $basket->getName(),
                'size' => $basket->getSize(),
                'price' => $basket->getPrice(),
            );
        }

        return null;
    }
}
