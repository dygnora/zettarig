<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Customer_model');
        $this->load->library('session');
        $this->load->helper('url');

        // proteksi login
        if (!$this->session->userdata('customer_login')) {
            redirect('auth/login');
        }
    }

    // ==================================================
    // DASHBOARD CUSTOMER
    // ==================================================
    public function index()
    {
        $customer_id = $this->session->userdata('customer_id');
        $customer    = $this->Customer_model->get_by_id($customer_id);

        if (!$customer) {
            redirect('auth/logout');
        }

        $data['title']    = 'Akun Saya | Zettarig';
        $data['customer'] = $customer;
        $data['content']  = 'web/akun/index';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // LOGOUT CUSTOMER
    // ==================================================
    public function logout()
    {
        $this->session->unset_userdata([
            'customer_id',
            'customer_nama',
            'customer_login'
        ]);

        redirect('produk');
    }

    // ==================================================
    // RIWAYAT PESANAN CUSTOMER
    // ==================================================
    public function pesanan()
    {
        $customer_id = $this->session->userdata('customer_id');

        $this->load->model('Penjualan_model');

        $data['title']    = 'Riwayat Pesanan | Zettarig';
        $data['pesanan']  = $this->Penjualan_model->get_by_customer($customer_id);
        $data['content']  = 'web/akun/pesanan';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // DETAIL PESANAN CUSTOMER
    // ==================================================
    public function pesanan_detail($id_penjualan)
    {
        $customer_id = $this->session->userdata('customer_id');

        $this->load->model('Penjualan_model');

        // ambil pesanan (validasi kepemilikan)
        $pesanan = $this->Penjualan_model
            ->get_detail_by_customer($id_penjualan, $customer_id);

        if (!$pesanan) {
            show_404();
        }

        $data['title']   = 'Detail Pesanan | Zettarig';
        $data['pesanan'] = $pesanan;
        $data['content'] = 'web/akun/pesanan_detail';

        $this->load->view('web/layout/template', $data);
    }


}
