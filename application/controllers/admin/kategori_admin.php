<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
        $this->load->library(['pagination', 'user_agent']);
    }

    // ==================================================
    // LIST KATEGORI + SEARCH + PAGINATION
    // ==================================================
    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q', true);
        $offset  = max((int) $this->input->get('page'), 0);
        $limit   = 10;

        // ==================================================
        // HITUNG TOTAL KATEGORI
        // ==================================================
        $total_rows = $this->Kategori_model->count_all($keyword);

        // ==================================================
        // KONFIGURASI PAGINATION (ADMINLTE STYLE)
        // ==================================================
        $config['base_url']             = base_url('admin/kategori');
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
        $data['title']      = 'Kategori Produk';
        $data['kategori']   = $this->Kategori_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;
        $data['content']    = 'admin/kategori/index';

        // ==================================================
        // RENDER VIA TEMPLATE
        // ==================================================
        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // FORM TAMBAH KATEGORI
    // ==================================================
    public function create()
    {
        $data = $this->data;

        $data['title']   = 'Tambah Kategori';
        $data['content'] = 'admin/kategori/create';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // SIMPAN KATEGORI BARU
    // ==================================================
    public function store()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true),
            'deskripsi'     => $this->input->post('deskripsi', true),
            'status_aktif'  => 1
        ];

        $this->Kategori_model->insert($data);
        redirect('admin/kategori');
    }

    // ==================================================
    // FORM EDIT KATEGORI
    // ==================================================
    public function edit($id)
    {
        $data = $this->data;

        $kategori = $this->Kategori_model->get_by_id($id);
        if (!$kategori) show_404();

        $data['title']    = 'Edit Kategori';
        $data['kategori'] = $kategori;
        $data['content']  = 'admin/kategori/edit';

        $this->load->view('admin/layout/template', $data);
    }

    // ==================================================
    // UPDATE KATEGORI
    // ==================================================
    public function update($id)
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true),
            'deskripsi'     => $this->input->post('deskripsi', true)
        ];

        $this->Kategori_model->update($id, $data);
        redirect('admin/kategori');
    }

    // ==================================================
    // NONAKTIFKAN KATEGORI
    // ==================================================
    public function nonaktif($id)
    {
        $this->Kategori_model->update($id, ['status_aktif' => 0]);
        redirect($this->agent->referrer() ?: 'admin/kategori');
    }

    // ==================================================
    // AKTIFKAN KATEGORI
    // ==================================================
    public function aktif($id)
    {
        $this->Kategori_model->update($id, ['status_aktif' => 1]);
        redirect($this->agent->referrer() ?: 'admin/kategori');
    }
}
