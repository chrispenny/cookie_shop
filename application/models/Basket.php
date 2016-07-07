<?php

namespace CookieShop\Model;

use CookieShop\Model\om\BaseBasket;

class Basket extends BaseBasket
{
    protected $cookies = array();

    protected $flagAsFull = false;

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param BasketCookie[] $basketCookies
     */
    public function setCookies($basketCookies)
    {
        foreach ($basketCookies as $basketCookie) {
            $this->addCookie($basketCookie->getCookieId(), $basketCookie->getQuantity());
        }
    }

    /**
     * @param array $cookies
     */
    public function setCookiesByArray($cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * @param int $cookieId
     * @param int $quantity
     * @return int|null
     */
    public function addCookie($cookieId, $quantity = 1)
    {
        if (!$this->isFlaggedAsFull()) {
            if (array_key_exists($cookieId, $this->cookies)) {
                $this->cookies[$cookieId] += $quantity;
            } else {
                $this->cookies[$cookieId] = $quantity;
            }

            if ($this->countCookies() == $this->size) {
                $this->flagAsFull();
            }

            return $this->cookies[$cookieId];
        }

        return null;
    }

    /**
     * @param int $cookieId
     * @return int|null
     */
    public function removeCookie($cookieId)
    {
        if (array_key_exists($cookieId, $this->cookies)) {
            $this->removeFlagAsFull();

            if ($this->cookies[$cookieId] > 1) {
                $this->cookies[$cookieId]--;
                return $this->cookies[$cookieId];
            }

            unset($this->cookies[$cookieId]);

            return 0;
        }

        return null;
    }

    /**
     * @return int
     */
    public function countCookies()
    {
        $total = 0;

        foreach ($this->cookies as $quantity) {
            $total += intval($quantity);
        }

        return $total;
    }

    /**
     * @return bool
     */
    public function isFlaggedAsFull()
    {
        return $this->flagAsFull;
    }

    /**
     * @return void
     */
    public function flagAsFull()
    {
        $this->flagAsFull = true;
    }

    /**
     * @return void
     */
    public function removeFlagAsFull()
    {
        $this->flagAsFull = false;
    }
}
