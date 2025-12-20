<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Cek Login
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('auth/login');
            exit;
        }
    }

    // ==================================================
    // DASHBOARD AKUN
    // ==================================================
    public function index()
    {
        // Load Model Customer jika belum di-autoload
        // $this->load->model('Customer_model'); 
        
        $customer_id = $this->session->userdata('customer_id');
        $customer    = $this->db->get_where('customer', ['id_customer' => $customer_id])->row();

        if (!$customer) {
            $this->logout(); 
            return;
        }

        $data['title']    = 'Akun Saya | Zettarig';
        $data['customer'] = $customer;
        $data['content']  = 'web/akun/index';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // RIWAYAT PESANAN
    // ==================================================
    public function pesanan()
    {
        $data['title']   = 'Riwayat Pesanan | Zettarig';
        
        // Ambil semua pesanan milik customer ini
        $data['pesanan'] = $this->Penjualan_model
            ->get_by_customer($this->session->userdata('customer_id'));
            
        $data['content'] = 'web/akun/pesanan';

        $this->load->view('web/layout/template', $data);
    }

    // ==================================================
    // DETAIL PESANAN (FIXED ERROR DISINI)
    // ==================================================
    public function pesanan_detail($id_penjualan)
    {
        $id_customer = $this->session->userdata('customer_id');

        // 1. AMBIL HEADER PESANAN
        // Pastikan pesanan ini milik customer yang sedang login
        $pesanan = $this->db->get_where('penjualan', [
            'id_penjualan' => $id_penjualan,
            'id_customer'  => $id_customer
        ])->row();

        if (!$pesanan) {
            show_404();
            return;
        }

        // 2. AMBIL DETAIL ITEM PRODUK (INI VARIABEL $detail YANG HILANG)
        $detail = $this->db->select('dp.*, p.nama_produk, p.gambar_produk')
            ->from('detail_penjualan dp')
            ->join('produk p', 'p.id_produk = dp.id_produk')
            ->where('dp.id_penjualan', $id_penjualan)
            ->get()
            ->result();

        // 3. AMBIL DATA COD (JIKA ADA)
        $cod = null;
        if ($pesanan->metode_pembayaran == 'cod') {
            $cod = $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row();
        }

        // 4. AMBIL TIMELINE
        $timeline = $this->db->order_by('waktu', 'ASC')
            ->get_where('timeline_pesanan', ['id_penjualan' => $id_penjualan])
            ->result();

        // KIRIM SEMUA KE VIEW
        $data['title']    = 'Detail Pesanan #' . $id_penjualan;
        $data['pesanan']  = $pesanan;
        $data['detail']   = $detail;   // <--- Solusi Error: Undefined variable detail
        $data['cod']      = $cod;      // <--- Data untuk fitur Upload DP
        $data['timeline'] = $timeline; 
        $data['content']  = 'web/akun/pesanan_detail';

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