<?php

namespace CookieShop\Models;

use CookieShop\Models\Base\TrolleyBasket as BaseTrolleyBasket;
use CookieShop\Trolley\TrolleyBasketCookieDisplayGroup;

/**
 * Skeleton subclass for representing a row from the 'trolley_basket' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TrolleyBasket extends BaseTrolleyBasket
{
    /**
     * @var TrolleyBasketCookieDisplayGroup[]
     */
    private $trolleyBasketCookieDisplayGroups;

    /**
     * @return TrolleyBasketCookieDisplayGroup[]
     */
    public function getTrolleyBasketCookieDisplayGroups()
    {
        if ($this->trolleyBasketCookieDisplayGroups === null) {
            $this->trolleyBasketCookieDisplayGroups = $this->generateTrolleyBasketCookieDisplayGroups();
        }

        return $this->trolleyBasketCookieDisplayGroups;
    }

    /**
     * @return TrolleyBasketCookieDisplayGroup[]
     */
    public function generateTrolleyBasketCookieDisplayGroups() {
        $groups = array();

        foreach ($this->getTrolleyBasketCookies() as $trolleyBasketCookie) {
            if (!array_key_exists($trolleyBasketCookie->getCookieId(), $groups)) {
                $groups[$trolleyBasketCookie->getCookieId()] = new TrolleyBasketCookieDisplayGroup();
            }

            $groups[$trolleyBasketCookie->getCookieId()]->addTrolleyBasketCookie($trolleyBasketCookie);
        }

        return $groups;
    }

    /**
     * @param Cookie $cookie
     */
    public function addCookie(Cookie $cookie)
    {
        $trolleyBasketCookie = new TrolleyBasketCookie();
        $trolleyBasketCookie->setCookie($cookie);

        $this->addTrolleyBasketCookie($trolleyBasketCookie);
    }

    /**
     * @param Cookie $cookie
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function removeCookie(Cookie $cookie)
    {
        $q = TrolleyBasketCookieQuery::create();
        $q->filterByCookie($cookie);

        // they're all identical, so it doesn't matter which one we remove
        $trolleyBasketCookie = $q->findOne();

        if ($trolleyBasketCookie === null) {
            throw new \Exception('No TrolleyBasketCookie found for Cookie ID: ' . $cookie->getId());
        }

        $this->removeTrolleyBasketCookie($trolleyBasketCookie);
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return $this->countTrolleyBasketCookies() == $this->getBasket()->getSize();
    }

    /**
     * @return bool
     */
    public function canDownsize()
    {
        $prevBasketSize = BasketPeer::getPrevBasketSize($this->getBasket());
        if ($prevBasketSize === null) {
            return false;
        }

        return $prevBasketSize->getSize() >= $this->countTrolleyBasketCookies();
    }
}
