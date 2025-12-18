<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pembayaran_model', 'pembayaran_model');
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url']);
    }

    // ==================================================
    // LIST PEMBAYARAN TRANSFER + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $offset = max((int) $this->input->get('page'), 0);
        $limit  = 10;

        // ==================================================
        // HITUNG TOTAL DATA
        // ==================================================
        $total_rows = $this->pembayaran_model->count_all();

        // ==================================================
        // KONFIGURASI PAGINATION (ADMINLTE STYLE)
        // ==================================================
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

        // ==================================================
        // DATA KE VIEW
        // ==================================================
        $data['title']      = 'Pembayaran Transfer';
        $data['pembayaran'] = $this->pembayaran_model
                                    ->get_paginated($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']     = $offset;
        $data['content']    = 'admin/pembayaran/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL PEMBAYARAN TRANSFER
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $pembayaran = $this->pembayaran_model->get_by_id($id);
        if (!$pembayaran) show_404();

        $data['title']      = 'Detail Pembayaran Transfer';
        $data['pembayaran'] = $pembayaran;
        $data['content']    = 'admin/pembayaran/detail';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // VERIFIKASI PEMBAYARAN
    // ==================================================
    public function verifikasi($id, $status)
    {
        if (!in_array($status, ['diterima', 'ditolak'])) {
            show_error('Status tidak valid');
        }

        $this->pembayaran_model->verifikasi($id, $status);
        redirect('admin/pembayaran');
    }
}
