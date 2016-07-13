<?php

/**
 * Created by: Chris Penny
 *
 * Note: CI return false for any requested data that cannot be found.
 * I prefer to return null if data is not found, so you'll see a lot of
 * this throughout the project:
 *
 * $value = CI->data('key') ?: null;
 *
 * Note 2: The above is no longer an issue in CI3, but I haven't had
 * time to revamp this project.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function index()
    {
        $trolley = \CookieShop\Models\TrolleyPeer::retrieveTrolley($this->session->userdata('id'));

        $data = array(
            'title' => 'Cart',
            'page' => 'cart/view_index',
            'trolley' => $trolley,
        );

        $this->load->view('template', $data);
    }

    public function edit()
    {
        $trolleyBasketId = $this->uri->segment(3) ?: null;

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            // set some kind of error into flash data.

            redirect('/cart');
        }

        $cookies = \CookieShop\Models\CookiePeer::retrieveCookies();

        $data = array(
            'title' => 'Cart',
            'page' => 'cart/view_edit',
            'trolleyBasket' => $trolleyBasket,
            'cookies' => $cookies,
        );

        $this->load->view('template', $data);
    }
}
