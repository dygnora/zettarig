<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_admin extends MY_Controller
{
    protected $is_admin = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Produk_model',
            'Kategori_model',
            'Brand_model'
        ]);
        $this->load->library(['pagination', 'user_agent']);
        $this->load->helper(['url', 'text']);
    }

    // ===============================
    // LIST PRODUK
    // ===============================
    public function index()
    {
        $data = $this->data;

        $keyword = $this->input->get('q');
        $page    = (int) $this->input->get('page');
        $limit   = 10;
        $offset  = ($page > 0 ? ($page - 1) * $limit : 0);

        $total = $this->Produk_model->count_all($keyword);

        $config['base_url']             = base_url('admin/produk');
        $config['total_rows']           = $total;
        $config['per_page']             = $limit;
        $config['page_query_string']    = true;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        $data['title']      = 'Produk';
        $data['produk']     = $this->Produk_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/produk/index', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $data = $this->data;

        $data['title']   = 'Tambah Produk';
        $data['kategori'] = $this->Kategori_model->get_all_active();
        $data['brand']    = $this->Brand_model->get_all_active();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/produk/create', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // STORE
    // ===============================
    public function store()
    {
        $data = [
            'nama_produk'  => $this->input->post('nama_produk', true),
            'id_kategori'  => $this->input->post('id_kategori'),
            'id_brand'     => $this->input->post('id_brand'),
            'harga_jual'   => $this->input->post('harga'),
            'status_aktif' => $this->input->post('status_aktif')
        ];

        $this->Produk_model->insert($data);
        redirect('admin/produk');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $data = $this->data;

        $data['produk'] = $this->Produk_model->get_by_id($id);
        if (!$data['produk']) show_404();

        $data['title']    = 'Edit Produk';
        $data['kategori'] = $this->Kategori_model->get_all_active();
        $data['brand']    = $this->Brand_model->get_all_active();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/produk/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update($id)
    {
        $data = [
            'nama_produk' => $this->input->post('nama_produk', true),
            'id_kategori' => $this->input->post('id_kategori'),
            'id_brand'    => $this->input->post('id_brand'),
            'harga_jual'  => $this->input->post('harga')
        ];

        $this->Produk_model->update($id, $data);
        redirect('admin/produk');
    }

    // ===============================
    // STATUS
    // ===============================
    public function aktif($id)
    {
        $this->Produk_model->set_status($id, 1);
        redirect($this->agent->referrer());
    }

    public function nonaktif($id)
    {
        $this->Produk_model->set_status($id, 0);
        redirect($this->agent->referrer());
    }
}
