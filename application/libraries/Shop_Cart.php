<?php

/**
 * Created by: Chris Penny
 *
 * Note: CI return false for any requested data that cannot be found.
 * I prefer to return null if data is not found, so you'll see a lot of
 * this throughout the project:
 *
 * Note 2: The above is no longer an issue in CI3, but I haven't had
 * time to revamp this project.
 *
 * $value = CI->data('key') ?: null;
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use CookieShop\Model\Basket;
use CookieShop\Model\BasketPeer;

class Shop_Cart
{

    protected $baskets = array();
    protected $CI = null;

    public function __construct()
    {
        $this->CI =& get_instance();
        $cart = $this->CI->session->userdata('cart') ?: null;

        if ($cart != null) {
            $this->baskets = unserialize($cart);
        }
    }

    /**
     * @return void
     */
    public function save()
    {
        $this->CI->session->set_userdata('cart', serialize($this->baskets));
    }

    /**
     * @param $id
     * @return Basket|null
     */
    public function addBasket($id)
    {
        if ($id != null) {
            $basket = BasketPeer::retrieveByPK($id);
            if ($basket !== null) {
                $basketCookies = \CookieShop\Model\BasketCookiePeer::retrieveByBasketId($id);
                $basket->setCookies($basketCookies);

                array_push($this->baskets, $basket);

                return $basket;
            }
        }

        return null;
    }

    /**
     * @param int $key
     * @return bool
     */
    public function removeBasket($key)
    {
        if ($key != null && array_key_exists($key, $this->baskets)) {
            unset($this->baskets[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param $key
     * @return Basket|null
     */
    public function getBasket($key)
    {
        if (array_key_exists($key, $this->baskets)) {
            return $this->baskets[$key];
        }

        return null;
    }

    /**
     * @return Basket[]
     */
    public function getBaskets()
    {
        return $this->baskets;
    }

    /**
     * @return int
     */
    public function countBaskets()
    {
        return sizeof($this->getBaskets());
    }

    /**
     * @param int $key
     * @param int $type
     * @return bool
     */
    public function setBasketType($key, $type)
    {
        $basket = $this->getBasket($key);
        if ($basket != null) {
            $newBasket = BasketPeer::retrieveByPK($type);
            if ($newBasket != null) {
                $newBasket->setCookiesByArray($basket->getCookies());

                if ($newBasket->countCookies() == $newBasket->getSize()) {
                    $newBasket->flagAsFull();
                }

                $this->baskets[$key] = $newBasket;

                return true;
            }
        }

        return false;
    }

}
