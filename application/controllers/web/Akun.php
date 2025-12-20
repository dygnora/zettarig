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

        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            exit;
        }
    }

    public function index()
    {
        $customer_id = $this->session->userdata('customer_id');
        $customer    = $this->Customer_model->get_by_id($customer_id);

        if (!$customer) {
            // Jika user dihapus dari DB, logout paksa
            $this->logout(); 
            return;
        }

        $data['title']    = 'Akun Saya | Zettarig';
        $data['customer'] = $customer;
        $data['content']  = 'web/akun/index';

        $this->load->view('web/layout/template', $data);
    }

    public function pesanan()
    {
        $this->load->model('Penjualan_model');

        $data['title']   = 'Riwayat Pesanan | Zettarig';
        $data['pesanan'] = $this->Penjualan_model
            ->get_by_customer($this->session->userdata('customer_id'));
        $data['content'] = 'web/akun/pesanan';

        $this->load->view('web/layout/template', $data);
    }

    public function pesanan_detail($id_penjualan)
    {
        $this->load->model('Penjualan_model');

        $pesanan = $this->Penjualan_model
            ->get_detail_by_customer(
                $id_penjualan,
                $this->session->userdata('customer_id')
            );

        if (!$pesanan) {
            show_404();
            return;
        }

        // ==================================================
        // LOAD TIMELINE (PENTING UNTUK CEK ALASAN TOLAK)
        // ==================================================
        $data['timeline'] = $this->Penjualan_model->get_timeline($id_penjualan);

        $data['title']   = 'Detail Pesanan | Zettarig';
        $data['pesanan'] = $pesanan;
        $data['content'] = 'web/akun/pesanan_detail';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // LOGOUT
    // ==================================================
    public function logout()
    {
        $this->session->unset_userdata([
            'customer_logged_in', 
            'customer_id', 
            'customer_nama', 
            'customer_email'
        ]);
        
        redirect('auth/login');
    }
}