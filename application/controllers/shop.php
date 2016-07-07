<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shop extends CI_Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Products',
            'page' => 'shop/view_index',
            'baskets' => \CookieShop\Model\BasketPeer::retrieveBaskets(),
            'cart' => new Shop_cart(),
        );

        $this->load->view('template', $data);
    }
}
