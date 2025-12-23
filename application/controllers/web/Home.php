<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Produk_model',
            'Banner_model'
        ]);
    }

    public function index()
    {
        $data = [
            'title'        => 'Zettarig | Retro Hardware Store',
            'banners'      => $this->Banner_model->get_active_banners(),
            
            // PERBAIKAN DI SINI: Gunakan key 'new_arrivals' agar terbaca di View
            'new_arrivals' => $this->Produk_model->get_featured_products(8),
            
            'content'      => 'web/home/index'
        ];

        $this->load->view('web/layout/template', $data);
    }
}