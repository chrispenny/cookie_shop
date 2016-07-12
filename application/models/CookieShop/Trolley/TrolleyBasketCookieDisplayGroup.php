<?php

namespace CookieShop\Trolley;

use CookieShop\Models\TrolleyBasketCookie;

class TrolleyBasketCookieDisplayGroup
{
    /**
     * @var TrolleyBasketCookie[]
     */
    private $trolleyBasketCookies = array();

    /**
     * @param TrolleyBasketCookie $trolleyBasketCookie
     */
    public function addTrolleyBasketCookie(TrolleyBasketCookie $trolleyBasketCookie)
    {
        $trolleyBasketCookie[] = $trolleyBasketCookie;
    }

    /**
     * @return \CookieShop\Models\Cookie|null
     */
    public function getCookie()
    {
        if (count($this->getTrolleyBasketCookies()) === 0) {
            return null;
        }

        return $this->trolleyBasketCookies[0]->getCookie();
    }

    /**
     * @return int|null
     */
    public function getCookieId()
    {
        if ($this->getCookie() === null) {
            return null;
        }

        return $this->getCookie()->getId();
    }

    /**
     * @return int
     */
    public function countTrolleyBasketCookies()
    {
        return count($this->trolleyBasketCookies);
    }

    /**
     * @return \CookieShop\Models\TrolleyBasketCookie[]
     */
    public function getTrolleyBasketCookies()
    {
        return $this->trolleyBasketCookies;
    }
}
