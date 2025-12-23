<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load Model Produk di sini
        $this->load->model('Produk_model');
    }

    public function index()
    {
        $data = [
            'title'        => 'Zettarig | Computer Parts',
            // Ambil data produk agar tidak kosong
            'new_arrivals' => $this->Produk_model->get_featured_products(4),
            'content'      => 'web/home/index'
        ];

        $this->load->view('web/layout/template', $data);
    }
}