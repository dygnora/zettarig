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

    public function index()
    {
        $data = $this->data; // 🔑 AMBIL DATA GLOBAL

        $keyword = $this->input->get('q', true);
        $offset  = (int) $this->input->get('page');
        $offset  = $offset < 0 ? 0 : $offset;
        $limit   = 10;

        $total_rows = $this->Kategori_model->count_all($keyword);

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

        $data['title']      = 'Kategori Produk';
        $data['kategori']   = $this->Kategori_model->get_paginated($limit, $offset, $keyword);
        $data['pagination'] = $this->pagination->create_links();
        $data['keyword']    = $keyword;
        $data['offset']     = $offset;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/kategori/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function edit($id)
    {
        $data = $this->data;

        $kategori = $this->Kategori_model->get_by_id($id);
        if (!$kategori) show_404();

        $data['title']    = 'Edit Kategori';
        $data['kategori'] = $kategori;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/navbar', $data);
        $this->load->view('admin/layout/sidebar', $data);
        $this->load->view('admin/kategori/edit', $data);
        $this->load->view('admin/layout/footer');
    }

    public function update($id)
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true),
            'deskripsi'     => $this->input->post('deskripsi', true)
        ];

        $this->Kategori_model->update($id, $data);

        $redirect = $this->input->post('redirect');
        redirect($redirect ?: 'admin/kategori');
    }

    public function nonaktif($id)
    {
        $this->Kategori_model->update($id, ['status_aktif' => 0]);
        redirect($this->agent->referrer() ?: 'admin/kategori');
    }

    public function aktif($id)
    {
        $this->Kategori_model->update($id, ['status_aktif' => 1]);
        redirect($this->agent->referrer() ?: 'admin/kategori');
    }
}
