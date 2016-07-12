<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shop extends CI_Controller
{
    public function index()
    {
        $baskets = \CookieShop\Models\BasketPeer::retrieveBaskets();
        $trolley = \CookieShop\Models\TrolleyPeer::retrieveTrolley($this->session->userdata('id'));

        $data = array(
            'title' => 'Products',
            'page' => 'shop/view_index',
            'baskets' => $baskets,
            'trolley' => $trolley,
        );

        $this->load->view('template', $data);
    }
}
