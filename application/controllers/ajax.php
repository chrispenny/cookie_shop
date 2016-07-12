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

class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!IS_AJAX) {
            redirect('/');
        }
    }

    public function index()
    {
        redirect('/');
    }

    public function add_basket()
    {
        $trolley = \CookieShop\Models\TrolleyPeer::retrieveTrolley($this->session->userdata('id'));

        $basketId = $this->input->post('basketId') ?: null;

        $basket = \CookieShop\Models\BasketPeer::retrieveByPk($basketId);
        if ($basket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Basket not found. ID: ' . $basketId,
            );

            echo json_encode($result);
            return;
        }

        try {
            $trolley->addBasket($basket);

            $conn = Propel::getConnection();
            $conn->beginTransaction();

            $trolley->save($conn);

            $conn->commit();

            $result = array(
                'status' => 1,
                'message' => 'Your ' . $basket->getName() . ' Basket has been added to your cart. You can now visit your cart and edit the contents of your Basket or close this box to continue shopping.',
            );
        } catch (\Exception $e) {
            $result = array(
                'status' => 0,
                'message' => 'Your basket could not be added, please refresh the page and try again.',
            );
        }

        $trolley->save();

        echo json_encode($result);
    }

    public function remove_basket()
    {
        $trolley = \CookieShop\Models\TrolleyPeer::retrieveTrolley($this->session->userdata('id'));

        $trolleyBasketId = $this->input->post('trolleyBasketId') ?: null;

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Trolley basket not found. ID: ' . $trolleyBasketId,
            );

            echo json_encode($result);
            return;
        }

        try {
            $trolley->removeTrolleyBasket($trolleyBasket);

            $conn = Propel::getConnection();
            $conn->beginTransaction();

            $trolley->save($conn);

            $result = array(
                'status' => 1,
                'message' => null,
            );
        } catch (\Exception $e) {
            $result = array(
                'status' => 0,
                'message' => 'Your Basket could not be removed, please refresh the page and try again.',
            );
        }

        echo json_encode($result);
    }

    public function add_cookie()
    {
        $trolleyBasketId = $this->input->post('trolleyBasketId') ?: null;
        $cookieId = $this->input->post('cookieId') ?: null;

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Trolley basket not found. ID: ' . $trolleyBasketId,
            );

            echo json_encode($result);
            return;
        }

        $cookie = \CookieShop\Models\CookiePeer::retrieveByPk($cookieId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Cookie not found. ID: ' . $cookieId,
            );

            echo json_encode($result);
            return;
        }

        try {
            if ($trolleyBasket->isFull()) {
                $nextBasketSize = \CookieShop\Models\BasketPeer::getNextBasketSizeAsArray($trolleyBasket->getBasket());

                if ($nextBasketSize === null) {
                    $result = array(
                        'status' => 0,
                        'message' => 'Your Basket is currently full, and here are no larger Baskets for you to upgrade to.<br /> Please either remove some cookies from the Basket, or purchase another Basket from the <a href="/">Shop</a>.',
                    );
                } else {
                    $result = array(
                        'status' => 2,
                        'nextBasket' => $nextBasketSize,
                    );
                }
            } else {
                $trolleyBasket->addCookie($cookie);

                $conn = Propel::getConnection();
                $conn->beginTransaction();

                $trolleyBasket->save($conn);

                $conn->commit();

                $result = array(
                    'status' => 1,
                    'quantity' => $trolleyBasket->countTrolleyBasketCookies(),
                );
            }
        } catch (\Exception $e) {
            $result = array(
                'status' => 0,
                'message' => 'Your Cookie could not be added. Please refresh the page and try again.',
            );
        }

        echo json_encode($result);
    }

    public function remove_cookie()
    {
        $trolleyBasketId = $this->input->post('trolleyBasketId') ?: null;
        $cookieId = $this->input->post('cookieId') ?: null;

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Trolley basket not found. ID: ' . $trolleyBasketId,
            );

            echo json_encode($result);
            return;
        }

        $cookie = \CookieShop\Models\CookiePeer::retrieveByPk($cookieId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Cookie not found. ID: ' . $cookieId,
            );

            echo json_encode($result);
            return;
        }

        try {
            $trolleyBasket->removeCookie($cookie);

            $conn = Propel::getConnection();
            $conn->beginTransaction();

            $trolleyBasket->save($conn);

            $conn->commit();

            if ($trolleyBasket->canDownsize()) {
                $result = array(
                    'status' => 2,
                    'quantity' => $trolleyBasket->countTrolleyBasketCookies(),
                    'prevBasket' => \CookieShop\Models\BasketPeer::getPrevBasketSizeAsArray($trolleyBasket->getBasket()),
                );
            } else {
                $result = array(
                    'status' => 1,
                    'quantity' => $trolleyBasket->countTrolleyBasketCookies(),
                );
            }
        } catch (\Exception $e) {
            $result = array(
                'status' => 0,
                'message' => 'Your Cookie could not be removed, please refresh the page and try again.',
            );
        }

        echo json_encode($result);
    }

    public function set_basket_type()
    {
        $trolleyBasketId = $this->input->post('trolleyBasketId') ?: null;
        $basketId = $this->input->post('basketId') ?: null;

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Trolley basket not found. ID: ' . $trolleyBasketId,
            );

            echo json_encode($result);
            return;
        }

        $basket = \CookieShop\Models\BasketPeer::retrieveByPk($basketId);
        if ($basket === null) {
            $result = array(
                'status' => 0,
                'message' => 'Basket not found. ID: ' . $basketId,
            );

            echo json_encode($result);
            return;
        }

        try {
            $trolleyBasket->setBasket($basket);

            $conn = Propel::getConnection();
            $conn->beginTransaction();

            $trolleyBasket->save($conn);

            $conn->commit();

            $result = array(
                'status' => 1,
                'message' => null,
            );
        } catch (\Exception $e) {
            $result = array(
                'status' => 0,
                'message' => 'Your Basket size could not be changed, please refresh the page and try again.',
            );
        }


        echo json_encode($result);
    }

    public function check_cart_count()
    {
        $trolley = \CookieShop\Models\TrolleyPeer::retrieveTrolley($this->session->userdata('id'));

        echo $trolley->countTrolleyBaskets();
    }
}
