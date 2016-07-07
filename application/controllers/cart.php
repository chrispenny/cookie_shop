<?php

use CookieShop\Model\CookiePeer;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Cart',
            'page' => 'cart/view_index',
            'cart' => new Shop_cart(),
        );

        $this->load->view('template', $data);
    }

    public function edit()
    {
        $key = $this->uri->segment(3);
        if ($key === false) {
            redirect('/');
        }

        $cart = new Shop_cart();

        $data = array(
            'title' => 'Cart',
            'page' => 'cart/view_edit',
            'cart' => $cart,
            'basket' => $cart->getBasket($key),
            'cookies' => CookiePeer::retrieveCookies(),
        );

        $this->load->view('template', $data);
    }
}
