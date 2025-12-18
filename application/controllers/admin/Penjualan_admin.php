<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->library(['pagination', 'user_agent']);
    }

    // ==================================================
    // LIST DATA PENJUALAN + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $offset = max((int) $this->input->get('page'), 0);
        $limit  = 10;

        // ==================================================
        // HITUNG TOTAL PENJUALAN
        // ==================================================
        $total_rows = $this->Penjualan_model->count_all();

        // ==================================================
        // KONFIGURASI PAGINATION (ADMINLTE STYLE)
        // ==================================================
        $config['base_url']             = base_url('admin/penjualan');
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
        $data['title']      = 'Data Penjualan';
        $data['penjualan']  = $this->Penjualan_model->get_paginated($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['offset']     = $offset;
        $data['content']    = 'admin/penjualan/index';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // DETAIL DATA PENJUALAN
    // ==================================================
    public function detail($id)
    {
        $data = $this->data;

        $penjualan = $this->Penjualan_model->get_by_id($id);
        if (!$penjualan) show_404();

        $data['title']     = 'Detail Penjualan';
        $data['penjualan'] = $penjualan;
        $data['detail']    = $this->Penjualan_model->get_detail($id);
        $data['timeline']  = $this->Penjualan_model->get_timeline($id);
        $data['content']   = 'admin/penjualan/detail';

        $this->load->view('admin/layout/template', $data);
    }
}
