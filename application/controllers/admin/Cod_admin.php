<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cod_admin extends MY_Controller
{
    // Properti ini memastikan hanya admin yang bisa akses (dari MY_Controller)
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        
        // Load Model dan Library yang dibutuhkan
        $this->load->model('Cod_model');
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url']);
    }

    // ==================================================
    // 1. HALAMAN UTAMA (LIST DAFTAR COD)
    // ==================================================
    public function index()
    {
        $data = $this->data; // Ambil data global (notifikasi, user login, dll)

        // Konfigurasi Pagination
        $offset = max((int) $this->input->get('page'), 0);
        $limit  = 10;

        $total_rows = $this->Cod_model->count_all();

        $config['base_url']             = base_url('admin/cod');
        $config['total_rows']           = $total_rows;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = true;

        // Styling Pagination (AdminLTE)
        $config['full_tag_open']  = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']  = '</a></li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        // Ambil Data dari Model
        $data['title']      = 'Manajemen COD & DP';
        $data['cod']        = $this->Cod_model->get_paginated($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']     = $offset;
        $data['content']    = 'admin/cod/index'; // View yang dimuat

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 2. HALAMAN DETAIL COD (Berdasarkan ID COD)
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        // Ambil detail data COD
        $cod = $this->Cod_model->get_by_id($id);
        
        // Jika data tidak ditemukan, tampilkan 404
        if (!$cod) show_404();

        $data['title']   = 'Detail Transaksi COD';
        $data['cod']     = $cod;
        $data['content'] = 'admin/cod/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // 3. [FIX] LOOKUP COD BERDASARKAN ID PENJUALAN
    // Fungsi ini dipakai saat redirect dari halaman Penjualan
    // ==================================================
    public function detail_by_penjualan($id_penjualan)
    {
        // Cari data di tabel pembayaran_cod berdasarkan id_penjualan
        $cod = $this->db->get_where('pembayaran_cod', ['id_penjualan' => $id_penjualan])->row();

        if ($cod) {
            // Jika ketemu, redirect ke halaman detail yang benar (pakai ID COD)
            redirect('admin/cod/detail/' . $cod->id_cod);
        } else {
            // Jika tidak ada (misal metode bayarnya bukan COD tapi Transfer)
            $this->session->set_flashdata('error', 'Data pembayaran COD tidak ditemukan untuk pesanan ini.');
            redirect($this->agent->referrer() ?: 'admin/penjualan');
        }
    }

    // ==================================================
    // 4. AKSI VERIFIKASI DP (TERIMA / TOLAK)
    // ==================================================
    public function verifikasi($id, $status)
    {
        // Validasi input status agar aman
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status verifikasi tidak valid.');
        }

        // Panggil Model untuk update status DP & Logika Pesanan
        $this->Cod_model->verifikasi_dp($id, $status);
        
        // Redirect kembali ke halaman sebelumnya
        redirect($this->agent->referrer() ?: 'admin/cod');
    }

    // ==================================================
    // 5. AKSI PELUNASAN (SETELAH BARANG SAMPAI)
    // ==================================================
    public function lunasi($id)
    {
        // Panggil Model untuk update status pelunasan & selesaikan pesanan
        $this->Cod_model->pelunasan($id);
        
        // Redirect kembali ke halaman sebelumnya
        redirect($this->agent->referrer() ?: 'admin/cod');
    }
}