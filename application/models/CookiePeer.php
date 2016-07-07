<?php

namespace CookieShop\Model;

use CookieShop\Model\om\BaseCookiePeer;

class CookiePeer extends BaseCookiePeer
{
    /**
     * @return Cookie[]
     */
    public static function retrieveCookies()
    {
        $q = CookieQuery::create();
        $q->orderByName(\Criteria::ASC);

        return $q->find();
    }
}
