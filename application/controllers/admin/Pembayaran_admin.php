<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();

        // Load Model Pembayaran (Pastikan file modelnya ada di bawah)
        $this->load->model('Pembayaran_model');
        
        // Load library pendukung
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url']);
    }

    // ==================================================
    // LIST PEMBAYARAN TRANSFER (ADMIN)
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $offset = max((int) $this->input->get('page'), 0);
        $limit  = 10;

        // Hitung total data
        $total_rows = $this->Pembayaran_model->count_all();

        // Konfigurasi Pagination
        $config['base_url']             = base_url('admin/pembayaran');
        $config['total_rows']           = $total_rows;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string']   = true;

        $config['full_tag_open']  = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['cur_tag_open']   = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close']  = '</a></li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['title']      = 'Pembayaran Transfer';
        $data['pembayaran'] = $this->Pembayaran_model->get_paginated($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']     = $offset;
        $data['content']    = 'admin/pembayaran/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL PEMBAYARAN
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $pembayaran = $this->Pembayaran_model->get_by_id($id);

        if (!$pembayaran) {
            show_404();
            return;
        }

        $data['title']      = 'Detail Pembayaran Transfer';
        $data['pembayaran'] = $pembayaran;
        $data['content']    = 'admin/pembayaran/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // AKSI VERIFIKASI (TRIGGER PERUBAHAN STATUS)
    // ==================================================
    public function verifikasi($id_pembayaran, $status)
    {
        // 1. Validasi Input Status
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
            return;
        }

        // 2. Ambil Data Pembayaran Dulu (Untuk tahu ID Penjualan)
        $pembayaran = $this->Pembayaran_model->get_by_id($id_pembayaran);
        if (!$pembayaran) show_404();

        // 3. Panggil Model untuk Update (Logika update 3 tabel ada di sini)
        $this->Pembayaran_model->proses_verifikasi($id_pembayaran, $pembayaran->id_penjualan, $status);

        // 4. Feedback ke Admin
        if ($status == 'diterima') {
            $this->session->set_flashdata('success', 'Pembayaran DITERIMA. Status pesanan berubah menjadi DIPROSES.');
        } else {
            $this->session->set_flashdata('success', 'Pembayaran DITOLAK. Customer diminta upload ulang.');
        }

        redirect('admin/pembayaran');
    }
}