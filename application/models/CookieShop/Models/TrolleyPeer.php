<?php

namespace CookieShop\Models;

class TrolleyPeer
{
    /**
     * @param $sessionId
     * @return Trolley
     *
     * NOTE: If I had a customer system in place this would check userdata('customerId) over sessionId
     */
    public static function retrieveTrolley($sessionId)
    {
        $q = \CookieShop\Models\Base\TrolleyQuery::create();
        $q->filterByCiSessionId($sessionId);

        $trolley = $q->findOne();

        if ($trolley === null) {
            $trolley = new \CookieShop\Models\Trolley();
            $trolley->setCiSessionId($sessionId);
        }

        return $trolley;
    }
}
