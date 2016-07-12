<?php

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
        $trolleyBasketId = $this->uri->segment(3);
        if ($trolleyBasketId === false) {
            // set some kind of error info flash data.

            redirect('/');
        }

        $trolleyBasket = \CookieShop\Models\TrolleyBasketPeer::retrieveByPk($trolleyBasketId);
        if ($trolleyBasket === null) {
            // set some kind of error info flash data.

            redirect('/');
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
