<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('Banner_model'); // Asumsi model baru utk tabel banner
    }

    public function index() {
        // Ambil data dinamis untuk Homepage
        $data['title'] = "Zettarig | Retro Hardware Store";
        $data['banners'] = $this->Banner_model->get_active_banners(); // Dari tabel 'banner'
        $data['featured'] = $this->Produk_model->get_featured_products(8); // Produk unggulan
        
        // Panggil view lewat wrapper template
        $data['content'] = 'web/home/index'; 
        $this->load->view('web/layout/template', $data);
    }
}