<?php

namespace CookieShop\Models;

class CookiePeer
{
    /**
     * @param $id
     * @return Cookie
     */
    public static function retrieveByPk($id)
    {
        $q = CookieQuery::create();
        $q->filterById($id);

        return $q->findOne();
    }

    /**
     * @return Cookie[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public static function retrieveCookies()
    {
        $q = CookieQuery::create();
        $q->orderByName();

        return $q->find();
    }
}
