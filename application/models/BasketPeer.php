<?php

namespace CookieShop\Model;

use CookieShop\Model\om\BaseBasketPeer;

class BasketPeer extends BaseBasketPeer
{
    /**
     * @return Basket[]
     */
    public static function retrieveBaskets()
    {
        $q = BasketQuery::create();
        $q->orderBySortOrder(\Criteria::DESC);

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
        $q->filterBySize($basket->countCookies(), \Criteria::EQUAL);

        return $q->findOne();
    }

    /**
     * @param Basket $basket
     * @param int $key
     * @return array|null
     */
    public static function getNextBasketSizeAsArray(Basket $basket, $key = null)
    {
        $basket = self::getNextBasketSize($basket);

        if ($basket !== null) {
            return array(
                'key' => $key,
                'type' => $basket->getId(),
                'name' => $basket->getName(),
                'size' => $basket->getSize(),
                'price' => $basket->getPrice(),
            );
        }

        return null;
    }

    /**
     * @param Basket $basket
     * @param int $key
     * @return array|null
     */
    public static function getPrevBasketSizeAsArray(Basket $basket, $key = null)
    {
        $basket = self::getPrevBasketSize($basket);

        if ($basket !== null) {
            return array(
                'key' => $key,
                'type' => $basket->getId(),
                'name' => $basket->getName(),
                'size' => $basket->getSize(),
                'price' => $basket->getPrice(),
            );
        }

        return null;
    }
}
