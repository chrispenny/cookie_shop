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

use CookieShop\Model\BasketPeer;

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
        $cart = new Shop_cart();

        $id = $this->input->post('id') ?: null;

        $basket = $cart->addBasket($id);
        if ($basket !== null) {
            $result = array(
                'status' => 1,
                'message' => 'Your ' . $basket->getName() . ' Basket has been added to your cart. You can now visit your cart and edit the contents of your Basket or close this box to continue shopping.',
            );
        } else {
            $result = array(
                'status' => 0,
                'message' => 'Your Basket could not be added, please refresh the page and try again.',
            );
        }

        $cart->save();

        echo json_encode($result);
    }

    public function remove_basket()
    {
        $cart = new Shop_cart();

        // a $key value of 0 is perfectly valid, but because PHP considers 0 == false, we can't use shorthand. Comparison of value type must be made.
        $key = $this->input->post('key') !== false ? $this->input->post('key') : null;

        if ($cart->removeBasket($key)) {
            $result = array(
                'status' => 1,
                'message' => null,
            );
        } else {
            $result = array(
                'status' => 0,
                'message' => 'Your Basket could not be removed, please refresh the page and try again.',
            );
        }

        $cart->save();

        echo json_encode($result);
    }

    public function add_cookie()
    {
        $cart = new Shop_cart();

        // a $key value of 0 is perfectly valid, but because PHP considers 0 == false, we can't use shorthand. Comparison of value type must be made.
        $key = $this->input->post('key') !== false ? $this->input->post('key') : null;
        $id = $this->input->post('id') ?: null;

        $basket = $cart->getBasket($key);
        if ($basket !== null) {
            if ($basket->isFlaggedAsFull()) {
                $results = array(
                    'status' => 2,
                    'quantity' => null,
                    'nextBasket' => BasketPeer::getNextBasketSizeAsArray($basket, $key),
                    'message' => 'Your Basket is currently full, and here are no larger Baskets for you to upgrade to.<br /> Please either remove some cookies from the Basket, or purchase another Basket from the <a href="/">Shop</a>.',
                );
            } else {
                $results = array(
                    'status' => 1,
                    'quantity' => $basket->addCookie($id),
                    'nextBasket' => null,
                    'message' => null,
                );

                $cart->save();
            }
        } else {
            $results = array(
                'status' => 0,
                'quantity' => null,
                'nextBasket' => null,
                'message' => 'Your Cookie could not be added. Please refresh the page and try again.',
            );
        }

        echo json_encode($results);
    }

    public function remove_cookie()
    {
        $cart = new Shop_cart();

        // a $key value of 0 is perfectly valid, but because PHP considers 0 == false, we can't use shorthand. Comparison of value type must be made.
        $key = $this->input->post('key') !== false ? $this->input->post('key') : null;
        $id = $this->input->post('id') ?: null;

        $basket = $cart->getBasket($key);
        if ($basket !== null) {
            $results = array(
                'status' => 1,
                'quantity' => $basket->removeCookie($id),
                'prevBasket' => BasketPeer::getPrevBasketSizeAsArray($basket, $key),
                'message' => null,
            );

            $cart->save();
        } else {
            $results = array(
                'status' => 2,
                'quantity' => null,
                'prevBasket' => null,
                'message' => 'Your Cookie could not be removed, please refresh the page and try again.',
            );
        }

        echo json_encode($results);
    }

    public function set_basket_type()
    {
        $cart = new Shop_cart();

        // a $key value of 0 is perfectly valid, but because PHP considers 0 == false, we can't use shorthand. Comparison of value type must be made.
        $key = $this->input->post('key') !== false ? $this->input->post('key') : null;
        $id = $this->input->post('type') ?: null;

        if ($cart->setBasketType($key, $id)) {
            $cart->save();

            $result = array(
                'status' => 1,
                'message' => null,
            );
        } else {
            $result = array(
                'status' => 0,
                'message' => 'Your Basket size could not be changed, please refresh the page and try again.',
            );
        }

        echo json_encode($result);
    }

    public function check_cart_count()
    {
        $cart = new Shop_cart();

        echo $cart->countBaskets();
    }
}
